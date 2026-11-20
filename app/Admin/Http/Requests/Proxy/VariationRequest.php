<?php

namespace App\Admin\Http\Requests\Proxy;

use App\Core\Http\Requests\Request;

class VariationRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'attr_id' => ['required', 'exists:App\Models\Attribute,id'],
            'name' => ['required', 'string'],
            'position' => ['nullable', 'integer'],
            'desc' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Variation,id'],
            'attr_id' => ['required', 'exists:App\Models\Attribute,id'],
            'name' => ['required', 'string'],
            'slug' => ['nullable'],
            'desc' => ['nullable'],
            'position' => ['nullable', 'integer'],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */

}