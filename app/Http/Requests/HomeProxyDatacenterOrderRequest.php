<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeProxyDatacenterOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'unit'           => 'required|integer|min:1',
            'quantity'       => 'required|integer|min:1',
            'protocol'     => 'required|string|in:HTTP,SOCKS',
            'location'     => 'required|string|in:random',
            'provider'     => 'required|string|in:CMC,US',
            'user'          => 'nullable|string',
            'password'          => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
