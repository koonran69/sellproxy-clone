<?php

namespace App\Admin\Http\Requests\Proxy;

use App\Core\Http\Requests\Request;

class ProxyRequest extends Request
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
            'short_desc' => ['nullable'],
            'desc' => ['nullable'],
            'sub_title' => ['nullable'],
            'category_id' => ['nullable'],
            'type_id' => ['nullable'],
            'status' => ['nullable'],
            'variations' => ['required', 'array'],
            'variations.*.price' => ['required', 'numeric', 'min:0'],
            'variations.*.price_promotion' => ['nullable', 'numeric', 'lt:variations.*.price'],
            'variations.*.duration' => ['required', 'string'],
            'variations.*.status' => ['required', 'in:10,20'],
            'variations.*.desc' => ['nullable', 'string'],
            'features' => ['nullable'],
            'short_title_description' => ['nullable'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Proxy,id'],
            'name' => ['required'],
            'sub_title' => ['nullable'],
            'feature_image' => ['nullable'],
            'short_desc' => ['nullable'],
            'desc' => ['nullable'],
            'slug' => ['required'],
            'lang' => 'nullable|string|in:vi,en',
            'category_id' => ['nullable'],
            'type_id' => ['nullable'],
            'status' => ['nullable'],
            'variations' => ['required', 'array'],
            'variations.*.price' => ['required', 'numeric', 'min:0'],
            'variations.*.price_promotion' => ['nullable', 'numeric', 'lt:variations.*.price'],
            'variations.*.duration' => ['required', 'string'],
            'variations.*.status' => ['required', 'in:10,20'],
            'variations.*.desc' => ['nullable', 'string'],
            'features' => ['nullable'],
            'short_title_description' => ['nullable'],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */

}
