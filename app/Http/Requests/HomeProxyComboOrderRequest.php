<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeProxyComboOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'string'],
            'unit' => ['required', 'integer', 'min:1'],
            'type_unit' => ['required', 'string', 'in:day,week,month'],
            'quantity' => ['required', 'integer', 'min:1'],
            'protocol' => ['required', 'string', 'in:HTTP,SOCKS5'],
            'provider' => ['nullable', 'string'],
            'user' => ['nullable', 'string', 'max:50'],
            'password' => ['nullable', 'string', 'max:50'],
            'payment_method' => ['required', 'string', 'in:WALLET'],
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
