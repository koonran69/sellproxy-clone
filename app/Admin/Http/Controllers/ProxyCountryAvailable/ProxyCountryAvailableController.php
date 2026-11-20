<?php

namespace App\Admin\Http\Controllers\ProxyCountryAvailable;

use App\Admin\DataTables\Contact\ContactDataTable;
use App\Admin\DataTables\ProxyCountryAvailable\ProxyCountryAvailableDataTable;
use App\Admin\DataTables\Proxyline\ProxylineDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Core\DataTables\DataTables;
use App\Core\Http\Requests\Request;
use App\Core\Repositories\Contact\ContactRepositoryInterface;
use App\Core\Repositories\ProxyCountryAvailable\ProxyCountryAvailableRepositoryInterface;
use App\Core\Repositories\ProxyPackage\ProxyPackageRepositoryInterface;
use App\Models\IpVersion;
use App\Models\ProxyCountry;
use App\Models\ProxyCountryAvailability;
use App\Models\ProxyLineType;
use App\Models\ProxyPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProxyCountryAvailableController extends Controller
{

    public function __construct(
        protected ProxyCountryAvailableRepositoryInterface $repository,
    ) {
    }

    public function index(): View|JsonResponse
    {
        return view('admin.proxy_country_available.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Quốc gia hỗ trợ'))
        ]);
    }

    public function ajax(Request $request)
    {
        $query = ProxyCountryAvailability::with(['country', 'type', 'ipVersion'])->select('*');

        return \Yajra\DataTables\Facades\DataTables::eloquent($query)->toJson();
    }

    public function create(): View
    {
        return view('admin.proxy_country_available.create')
            ->with('proxyTypes', ProxyLineType::get())
            ->with('ipVersions', IpVersion::get())
            ->with('countries', ProxyCountry::get())
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Quốc gia hỗ trợ'), 'admin.proxy_country_available.index')->addByRouteName(trans('add'), ''));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'proxy_type_id' => 'required|exists:proxy_line_types,id',
            'ip_version_id' => 'required|exists:ip_versions,id',
            'country_ids' => 'required|array|min:1',
            'country_ids.*' => 'exists:proxy_countries,id',
        ]);

        foreach ($validated['country_ids'] as $countryId) {
            ProxyCountryAvailability::firstOrCreate([
                'country_id' => $countryId,
                'proxy_type_id' => $validated['proxy_type_id'],
                'ip_version_id' => $validated['ip_version_id'],
                'is_available' => 1
            ]);
        }

        return to_route('admin.proxy_country_available.index')->with('success', __('notifySuccess'));
    }

    public function edit(Request $request): View
    {
        $typeId = $request->type_id;
        $versionId = $request->ip_version_id;

        $groupItems = ProxyCountryAvailability::with('country')
            ->where('proxy_type_id', $typeId)
            ->where('ip_version_id', $versionId)
            ->get();

        $selectedCountryIds = $groupItems->pluck('country_id')->toArray() ?? [];
        return view('admin.proxy_country_available.edit')
            ->with('groupItems', $groupItems)
            ->with('typeId', $typeId)
            ->with('versionId', $versionId)
            ->with('selectedCountryIds', $selectedCountryIds)
            ->with('proxyTypes', ProxyLineType::get())
            ->with('ipVersions', IpVersion::get())
            ->with('countries', ProxyCountry::get())
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Edit Quốc gia hỗ trợ'), 'admin.proxy_country_available.index')->addByRouteName(trans('edit'), ''));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'typeId' => 'required|exists:proxy_line_types,id',
            'versionId' => 'required|exists:ip_versions,id',
            'country_ids' => 'required|array|min:1',
            'country_ids.*' => 'exists:proxy_countries,id',
        ]);


        DB::beginTransaction();

        try {

            ProxyCountryAvailability::where('proxy_type_id', $validated['typeId'])
                ->where('ip_version_id', $validated['versionId'])
                ->delete();

            foreach ($validated['country_ids'] as $countryId) {
                ProxyCountryAvailability::create([
                    'proxy_type_id' => $validated['typeId'],
                    'ip_version_id' => $validated['versionId'],
                    'country_id' => $countryId,
                    'is_available' => 1
                ]);
            }
            DB::commit();

            return to_route('admin.proxy_country_available.index')->with('success', __('notifySuccess'));
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->ajax()) {
                throw $th;
            }
            return back()->withInput()->withErrors(['errors' => $th->getMessage()]);
        }

    }
}
