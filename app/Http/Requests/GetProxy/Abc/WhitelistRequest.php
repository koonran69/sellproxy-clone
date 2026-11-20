<?php

namespace App\Http\Requests\GetProxy\Abc;

use App\Core\Http\Requests\Request;

class WhitelistRequest extends Request
{

    protected function methodPost()
    {
        if ($this->routeIs('getProxies.abcproxy.whitelist.add')) {
            return [
                'ips' => ['required', 'string'],
            ];
        }

        if ($this->routeIs('getProxies.abcproxy.whitelist.lock')) {
            return [
                'ips' => ['required', 'string'],
                'status' => ['required', 'numeric', 'in:0,1'],
            ];
        }

        if ($this->routeIs('getProxies.abcproxy.whitelist.delete')) {
            return [
                'ips' => ['required', 'string'],
            ];
        }

        return [];
    }

    protected function methodGet()
    {
        if ($this->routeIs('getProxies.abcproxy.whitelist.proxyInfo')) {
            return [
                'proxy_type'  => ['nullable', 'string'],
                'quantity'    => ['nullable', 'numeric', 'min:1', 'max:500'],
                'region_code' => ['nullable', 'string'],
                'ip_mode'     => ['nullable', 'numeric', 'in:0,1'],
                'protocol'    => ['nullable', 'numeric', 'in:1,2'],
                'format'      => ['nullable', 'string', 'in:txt,json'],
                'white_ips'   => ['nullable', 'string'],
                'status'      => ['nullable', 'numeric', 'in:0,1'],
            ];
        }

        return [];
    }
}
