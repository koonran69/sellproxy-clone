<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProxyResidentialStaticOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'service_id'           => 'required',
            'plan_id'       => 'nullable',
            'country'       => 'nullable',
            'isp'           => 'nullable',
            'quantity'       => 'nullable',
            'months'     => 'nullable',
            'traffic'     => 'nullable',
            'package_id' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
