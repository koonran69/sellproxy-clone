<?php

namespace App\Http\Requests\GetProxy;

use App\Core\Enums\GetProxy\ProxyProvider;
use App\Core\Http\Requests\Request;
use Illuminate\Validation\Rules\Enum;

class ProxyConnectRequest extends Request
{
    protected function methodPost()
    {
        return [
            'provider' => ['required', 'integer', new Enum(ProxyProvider::class)],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ];
    }
}
