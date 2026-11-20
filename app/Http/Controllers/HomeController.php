<?php

namespace App\Http\Controllers;

use App\Core\Enums\DefaultStatus;
use App\Core\Enums\ProxyStatus;
use App\Core\Enums\Setting\SettingGroup;
use App\Models\Proxy;
use App\Models\ProxyCategory;
use App\Models\ProxyType;
use App\Models\QA;
use App\Models\Setting;
use App\Services\AuthService;
use App\Services\ProxyService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $proxyService;

    public function __construct(ProxyService $proxyService)
    {
        $this->proxyService = $proxyService;
    }

    public function index(Request $request) {
        $filter['cate_id'] = $request->input('cate_id', 'all');
        $filter['type_id'] = $request->input('type_id', 'all');
        $filter['keyword'] = $request->input('keyword', 'all');
        //$data['categories'] = ProxyCategory::select("id","name","feature_image")->where("status", DefaultStatus::Published)->orderBy('position')->get();
        $data['types'] = ProxyType::select("id","name","feature_image")->where("status", DefaultStatus::Published)->orderBy('position')->get();
        $data['proxies'] = $this->proxyService->getListProxyHomePage($filter);
        //$data['feature_proxies'] = $this->proxyService->getListProxyHomePage(['cate_id' => 'all']);
        $data['filter'] = $filter;
        $data['qas'] = QA::select("id","question","answer")->where("status", DefaultStatus::Published)->orderBy('position')->get();

        $proxyFeatures = Proxy::with([
            'minVariation:id,proxy_id,price,price_promotion,duration,variation_id',
            'minVariation.variation:id,name,attr_id',
        ])->where('status', ProxyStatus::Available)->whereHas('minVariation');
        $proxyFeatures = $proxyFeatures->orderByRaw('name_main REGEXP "^[0-9]" DESC')
            ->orderBy('name_main', 'asc')
            ->limit(10)->get();

        $setting_features = Setting::getBy(filter:[
            'group' => SettingGroup::ProxyFeature
        ], sort: ['id', 'asc']);

        $data['setting_features'] = $setting_features;
        $data['proxyFeatures'] = $proxyFeatures;
        return view("public.index")->with($data);
    }
}
