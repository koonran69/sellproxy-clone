<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProxyStaticOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $providers = implode(',', array_keys(config('proxyhome.product_ids.static', [])));
        $protocols = implode(',', config('proxyhome.protocols', []));

        return [
            'provider'       => "required|string|in:{$providers}",
            'days'           => 'required|integer|min:1',
            'quantity'       => 'required|integer|min:1',
            'protocolType'   => "required|string|in:{$protocols}",
            'location'       => 'nullable|string|max:50',
            'user'           => 'required|string|max:100',
            'password'       => 'required|string|max:100',
            'product_id'     => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'provider.in'     => 'Nhà mạng không hợp lệ.',
            'protocolType.in' => 'Giao thức không hợp lệ.',
        ];
    }
}