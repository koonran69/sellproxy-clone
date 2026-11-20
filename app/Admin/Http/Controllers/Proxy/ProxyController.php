<?php

namespace App\Admin\Http\Controllers\Proxy;

use App\Admin\DataTables\Proxy\HistoryLoginGetProxyDataTable;
use App\Admin\DataTables\Proxy\ProxyDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Proxy\ProxyRequest;
use App\Core\Enums\ProxyStatus;
use App\Core\Enums\Setting\SettingGroup;
use App\Core\Repositories\Proxy\ProxyRepositoryInterface;
use App\Models\Attribute;
use App\Models\Proxy;
use App\Models\ProxyCategory;
use App\Models\ProxyType;
use App\Models\ProxyVariation;
use App\Models\Setting;
use App\Models\Variation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProxyController extends Controller
{
    public function __construct(
        public ProxyRepositoryInterface $repository,
        public ProxyCategory $proxyCategory,
        public ProxyType $proxyType,
        public Attribute $attribute,
        public Variation $variation,
        public ProxyVariation $proxyVariation
    ) {
    }

    public function historyLogin(HistoryLoginGetProxyDataTable $datatable): JsonResponse|View
    {
        return $datatable->render('admin.proxies.histories.login', [
            'breadcrums' => $this->breadcrums()->addByRouteName(trans('Proxy'), ''),
        ]);
    }

    public function index(ProxyDataTable $datatable): JsonResponse|View
    {
        return $datatable->render('admin.proxies.index', [
            'breadcrums' => $this->breadcrums()->addByRouteName(trans('Proxy'), ''),
        ]);

    }

    public function create(): View
    {
        $proxyCategories = $this->proxyCategory->getAll();
        $proxyTypes = $this->proxyType->getAll();
        $attrs = $this->attribute->getAll();
        $variations = $this->variation->getAll()->groupBy('attr_id');

        $setting_features = Setting::getBy(filter:[
            'group' => SettingGroup::ProxyFeature
        ], sort: ['id', 'asc']);

        return view('admin.proxies.create')
            ->with('variations', $variations)
            ->with('attrs', $attrs)
            ->with('proxy_categories', $proxyCategories)
            ->with('proxy_types', $proxyTypes)
            ->with('status', ProxyStatus::asSelectArray())
            ->with('setting_features', $setting_features)
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Proxy'), 'admin.proxy.index')->addByRouteName(trans('add'), ''));
    }

    public function store(ProxyRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $proxy = $this->repository->create($data);

            if (!empty($data['variations'])) {
                foreach ($data['variations'] as $variationId => $variation) {
                    $proxyVariation = $this->proxyVariation->firstOrNew([
                        'proxy_id' => $proxy->id,
                        'variation_id' => $variationId,
                    ]);

                    $proxyVariation->price = $variation['price'];
                    $proxyVariation->price_promotion = $variation['price_promotion'] ?? null;
                    $proxyVariation->status = $variation['status'];
                    $proxyVariation->desc = $variation['desc'] ?? null;

                    $proxyVariation->setTranslation('duration', app()->getLocale(), $variation['duration'] ?? null);

                    $proxyVariation->save();
                }
            }
            if ($proxy) {
                $this->updateForSearchable($proxy->id);
                DB::commit();
                return $request->input('submitter') == 'save'
                    ? to_route('admin.proxy.edit', $proxy->id)->with('success', __('notifySuccess'))
                    : to_route('admin.proxy.index')->with('success', __('notifySuccess'));
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id, $lang = 'vi'): View
    {
        $proxy = $this->repository->findOrFail($id, ['variations', 'category', 'type']);

        $proxyCategories = $this->proxyCategory->getAll();
        $proxyTypes = $this->proxyType->getAll();
        $attrs = $this->attribute->getAll();
        $variations = $this->variation->orderBy('position','ASC')->get()->groupBy('attr_id');
        $setting_features = Setting::getBy(filter:[
            'group' => SettingGroup::ProxyFeature
        ], sort: ['id', 'asc']);
        // app()->setLocale($lang);

        $proxyVariations = $proxy->variations->pluck('id')->toArray();

        return view('admin.proxies.edit')->with('proxy', $proxy)
            ->with('proxy_variations', $proxyVariations)
            ->with('variations', $variations)
            ->with('attrs', $attrs)
            ->with('lang', $lang)
            ->with('proxy_categories', $proxyCategories)
            ->with('proxy_types', $proxyTypes)
            ->with('status', ProxyStatus::asSelectArray())
            ->with('setting_features', $setting_features)
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Proxy'), 'admin.proxy.index')->addByRouteName(trans('edit'), ''));
    }

    public function update(ProxyRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $lang = $data['lang'] ?? 'vi';

            $proxy = $this->repository->findOrFail($data['id']);
            if ($lang === 'vi') {
                $proxy->update($data);
            } else {
                $proxy->setTranslation('name', $lang, $data['name']);
                $proxy->setTranslation('sub_title', $lang, $data['sub_title']);
                $proxy->setTranslation('short_desc', $lang, $data['short_desc']);
                $proxy->setTranslation('desc', $lang, $data['desc']);
                $proxy->save();
            }

            if (!empty($data['variations'])) {
                $variations = [];
                foreach ($data['variations'] as $variationId => $variation) {

                    $oldDuration = $proxy->variations()->wherePivot('variation_id', $variationId)->first()?->pivot->duration;
                    $oldDuration = is_string($oldDuration) ? json_decode($oldDuration, true) : [];

                    $oldDuration[$lang] = $variation['duration'];

                    $variations[$variationId] = [
                        'price' => $variation['price'],
                        'price_promotion' => $variation['price_promotion'] ?? null,
                        'duration' => json_encode($oldDuration),
                        'status' => $variation['status'],
                        'desc' => $variation['desc'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                $proxy->variations()->sync($variations);
            }

            DB::commit();
            if ($proxy) {
                $this->updateForSearchable($proxy->id);
                return $request->input('submitter') == 'save'
                    ? back()->with('success', __('notifySuccess'))
                    : to_route('admin.proxy.index')->with('success', __('notifySuccess'));
            }

            return back()->with('errors', __('notifyFail'));

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete($id): RedirectResponse|JsonResponse
    {
        try {
            $this->repository->delete($id);

            if (request()->ajax()) {
                return utilities()->responseAjax();
            }

            return to_route('admin.proxy.index')->with('success', __('notifySuccess'));
        } catch (\Throwable $th) {

            if (request()->ajax()) {
                throw $th;
            }
            return back()->withErrors(['errors' => $th->getMessage()]);
        }
    }
    public function searchSelect(Request $request)
    {
        return [
            'results' => $this->repository->searchSelect($request->input('term', ''))
        ];
    }

    public function updateForSearchable($proxy_id)
    {
        $proxy = Proxy::find($proxy_id);
        $variationMin = $proxy->minVariation()->first();
        $price_promotion = $variationMin->price_promotion && $variationMin->price_promotion > 0 ? $variationMin->price_promotion : $variationMin->price;
        $name_main = !empty($proxy->getTranslation('name', 'vi')) ? $proxy->getTranslation('name', 'vi') : $proxy->getTranslation('name', 'en');
        Proxy::where('id', $proxy->id)->update(['price' => $variationMin->price, 'price_promotion' => $price_promotion, 'name_main' => $name_main ]);
    }
}
