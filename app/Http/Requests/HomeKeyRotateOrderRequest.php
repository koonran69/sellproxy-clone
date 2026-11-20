<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeKeyRotateOrderRequest extends FormRequest
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
            'typeUnit'     => 'required|string|in:day,week,month',
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
