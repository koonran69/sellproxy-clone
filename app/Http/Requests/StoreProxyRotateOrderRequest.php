<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProxyRotateOrderRequest extends FormRequest
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
            'user'           => 'required|string|max:100',
            'password'       => 'required|string|max:100',
            'product_id'     => 'nullable|string|max:100',
            'typeUnit'     => 'string|in:day,week,month',
            'interval' => 'required',
            'auto' => 'required'
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}