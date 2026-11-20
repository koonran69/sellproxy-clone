<?php

namespace App\Admin\Http\Requests\Proxy;

use App\Core\Http\Requests\Request;

class TypeRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'name' => ['required'],
            'feature_image' => ['nullable'],
            'status' => ['required'], 
            'position' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\ProxyType,id'],
            'name' => ['required'],
            'slug' => ['required'],
            'feature_image' => ['nullable'],
            'status' => ['required'], 
            'position' => ['nullable'],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */

}