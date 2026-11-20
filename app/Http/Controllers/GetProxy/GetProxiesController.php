<?php

namespace App\Http\Controllers\GetProxy;

use App\Core\Enums\GetProxy\ProxyProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class GetProxiesController extends Controller
{
    public function index(string $slug = 'abcproxy')
    {
        $provider = ProxyProvider::fromSlug($slug) ?? ProxyProvider::Abc;

        if (Session::has($provider->getSessionTokenKey())) {

            return redirect()->route("getProxies.{$provider->slug()}.index");
        }

        $providers = ProxyProvider::all();

        foreach ($providers as $key => &$p) {

            $p['is_connected'] = Session::has(ProxyProvider::tryFrom($key)->getSessionTokenKey());
        }

        return view('get-proxies.index', [
            'activeProvider' => $provider->value,
            'providers'      => $providers,
        ]);
    }
}
