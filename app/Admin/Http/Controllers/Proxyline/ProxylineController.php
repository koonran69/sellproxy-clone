<?php

namespace App\Admin\Http\Controllers\Proxyline;

use App\Admin\DataTables\Contact\ContactDataTable;
use App\Admin\DataTables\Proxyline\ProxylineDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Core\Http\Requests\Request;
use App\Core\Repositories\Contact\ContactRepositoryInterface;
use App\Core\Repositories\ProxyPackage\ProxyPackageRepositoryInterface;
use App\Models\IpVersion;
use App\Models\ProxyCountry;
use App\Models\ProxyLineType;
use App\Models\ProxyPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProxylineController extends Controller
{

    public function __construct(
        protected ProxyPackageRepositoryInterface $repository,
    ) {
    }

    public function index(ProxylineDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.proxylines.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Gói Proxyline'))
        ]);
    }

    public function create(): View
    {
        return view('admin.proxylines.create')
            ->with('proxyTypes', ProxyLineType::get())
            ->with('ipVersions', IpVersion::get())
            ->with('countries', ProxyCountry::get())
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Thêm bảng giá'), 'admin.proxyline.index')->addByRouteName(trans('add'), ''));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'proxy_type_id' => 'required|exists:proxy_line_types,id',
            'ip_version_id' => 'required|exists:ip_versions,id',
            'duration_days' => 'required',
            'min_quantity' => 'required|integer|min:1|lt:max_quantity',
            'max_quantity' => 'required|integer|gt:min_quantity',
            'price_per_ip' => 'required|numeric|min:0.01',
            'country_ids' => 'required|array|min:1',
            'country_ids.*' => 'exists:proxy_countries,id',
        ]);

        foreach ($validated['country_ids'] as $countryId) {
            $exists = DB::table('proxy_price_tiers as ppt')
                ->join('proxy_price_tier_countries as c', 'ppt.id', '=', 'c.proxy_price_tier_id')
                ->where('ppt.proxy_type_id', $validated['proxy_type_id'])
                ->where('ppt.ip_version_id', $validated['ip_version_id'])
                ->where('ppt.duration_days', $validated['duration_days'])
                ->where('ppt.min_quantity', $validated['min_quantity'])
                ->where('ppt.max_quantity', $validated['max_quantity'])
                ->where('c.country_id', $countryId)
                ->exists();

            if ($exists) {
                return back()->withErrors([
                    'country_ids' => "Một hoặc nhiều quốc gia đã có trùng cấu hình này."
                ])->withInput();
            }
        }

        DB::beginTransaction();

        try {
            $tier = ProxyPackage::create([
                'proxy_type_id' => $validated['proxy_type_id'],
                'ip_version_id' => $validated['ip_version_id'],
                'duration_days' => $validated['duration_days'],
                'min_quantity' => $validated['min_quantity'],
                'max_quantity' => $validated['max_quantity'],
                'price_per_ip' => $validated['price_per_ip'],
            ]);

            $tier->countries()->attach($validated['country_ids']);

            DB::commit();

            return $request->input('submitter') == 'save'
                ? to_route('admin.proxyline.edit', $tier->id)->with('success', __('notifySuccess'))
                : to_route('admin.proxyline.index')->with('success', __('notifySuccess'));
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->ajax()) {
                throw $th;
            }
            return back()->withInput()->withErrors(['errors' => $th->getMessage()]);
        }
    }

    public function edit($id): View
    {
        $proxyline = $this->repository->findOrFail($id);
        $selectedCountryIds = $proxyline?->countries->pluck('id')->toArray() ?? [];
        return view('admin.proxylines.edit')
            ->with('proxyline', $proxyline)
            ->with('selectedCountryIds', $selectedCountryIds)
            ->with('proxyTypes', ProxyLineType::get())
            ->with('ipVersions', IpVersion::get())
            ->with('countries', ProxyCountry::get())
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Edit bảng giá'), 'admin.proxyline.index')->addByRouteName(trans('add'), ''));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'proxy_type_id' => 'required|exists:proxy_line_types,id',
            'ip_version_id' => 'required|exists:ip_versions,id',
            'duration_days' => 'required',
            'min_quantity' => 'required|integer|min:1|lt:max_quantity',
            'max_quantity' => 'required|integer|gt:min_quantity',
            'price_per_ip' => 'required|numeric|min:0.01',
            'country_ids' => 'required|array|min:1',
            'country_ids.*' => 'exists:proxy_countries,id',
        ]);

        $proxyline = $this->repository->findOrFail($request->id);

        foreach ($validated['country_ids'] as $countryId) {
            $exists = DB::table('proxy_price_tiers as ppt')
                ->join('proxy_price_tier_countries as c', 'ppt.id', '=', 'c.proxy_price_tier_id')
                ->where('ppt.id', '!=', $proxyline->id)
                ->where('ppt.proxy_type_id', $validated['proxy_type_id'])
                ->where('ppt.ip_version_id', $validated['ip_version_id'])
                ->where('ppt.duration_days', $validated['duration_days'])
                ->where('ppt.min_quantity', $validated['min_quantity'])
                ->where('ppt.max_quantity', $validated['max_quantity'])
                ->where('c.country_id', $countryId)
                ->exists();

            if ($exists) {
                return back()->withErrors([
                    'country_ids' => "Một hoặc nhiều quốc gia đã có tier trùng cấu hình này."
                ])->withInput();
            }
        }

        DB::beginTransaction();

        try {

            $proxyline->update([
                'proxy_type_id' => $validated['proxy_type_id'],
                'ip_version_id' => $validated['ip_version_id'],
                'duration_days' => $validated['duration_days'],
                'min_quantity' => $validated['min_quantity'],
                'max_quantity' => $validated['max_quantity'],
                'price_per_ip' => $validated['price_per_ip'],
            ]);

            $proxyline->countries()->sync($validated['country_ids']);

            DB::commit();

            return $request->input('submitter') == 'save' ? utilities()->responseBack() : utilities()->toRoute('admin.proxyline.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->ajax()) {
                throw $th;
            }
            return back()->withInput()->withErrors(['errors' => $th->getMessage()]);
        }

    }
}
