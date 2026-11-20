<?php

namespace App\Services;

use App\Core\Repositories\Proxy\ProxyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProxyService
{
    private $proxyRepo;

    public function __construct(ProxyRepositoryInterface  $proxyRepo) {
        $this->proxyRepo = $proxyRepo;
    }

    public function getListProxyItems($filter, $sort) {
        return $this->proxyRepo->getListProxyMinPrice($filter, $sort);
    }

    public function getProxyBySlug($slug) {
        $proxy = $this->proxyRepo->getProxyBySlug($slug);
        return compact('proxy');
    }

    public function getListProxyHomePage($filter) {
        return $this->proxyRepo->getListProxyHomePage($filter);
    }
}