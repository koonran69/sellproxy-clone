<?php

namespace App\Admin\Http\Requests\Proxy;

use App\Core\Http\Requests\Request;

class AttributeRequest extends Request
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
            'position' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Attribute,id'],
            'name' => ['required'],
            'slug' => ['required'],
            'position' => ['nullable']
        ];
    }

    /**
     * Handle a passed validation attempt.
     */

}