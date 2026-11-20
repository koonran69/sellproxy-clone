<?php

namespace App\Http\Controllers;

use App\Core\Enums\DefaultStatus;
use App\Models\ProxyCategory;
use App\Services\ProxyService;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    private $proxyService;

    public function __construct(ProxyService $proxyService) {
        $this->proxyService = $proxyService;
    }

    public function listProxies(Request $request) {
        $filter = $request->all();
        $filter['cate_id'] = $filter['cate_id'] ?? "all";
        $sort = $request->sort && in_array($request->sort, [ "bestSeller", "latest", "priceLow", "priceHigh", "az", "za","09"]) ? $request->sort : "09";
        $data['proxies'] = $this->proxyService->getListProxyItems($filter, $sort);
        $data['categories'] = ProxyCategory::select("id","name","feature_image")->where("status", DefaultStatus::Published)->orderBy('position')->get();
        $data['filter'] = $filter;
        $data['sort'] = $sort;
        return view("public.proxy.listItems")->with($data);
    }

    public function proxyDetail(Request $request, $slug) {
        $data = $this->proxyService->getProxyBySlug($slug);
        if(!$data['proxy']) {
            abort(404);
        }
        return view("public.proxy.detail_v2")->with($data);
    }
}
