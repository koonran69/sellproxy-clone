<?php

namespace App\Admin\Http\Requests\Blog\Post;

use App\Core\Enums\DefaultStatus;
use App\Core\Http\Requests\Request;
use Illuminate\Validation\Rules\Enum;

class PostRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'categories_id' => ['required', 'array'],
            'categories_id.*' => ['required', 'exists:App\Models\Category,id'],
            'title' => ['required', 'string'],
            'feature_image' => ['required'],
            'status' => ['required', new Enum(DefaultStatus::class)],
            'excerpt' => ['nullable'],
            'content' => ['nullable'],
            'posted_at' => ['nullable', 'date_format:Y-m-d H:i'],
            'is_feature' => ['nullable', 'boolean'],
            'is_hot' => ['nullable', 'boolean'],
            'title_seo' => ['nullable', 'string'],
            'desc_seo' => ['nullable'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Post,id'],
            'categories_id' => ['required', 'array'],
            'categories_id.*' => ['required', 'exists:App\Models\Category,id'],
            'title' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:App\Models\Post,slug,' . $this->id],
            'feature_image' => ['required'],
            'status' => ['required', new Enum(DefaultStatus::class)],
            'excerpt' => ['nullable'],
            'content' => ['nullable'],
            'is_feature' => ['nullable', 'boolean'],
            'is_hot' => ['nullable', 'boolean'],
            'title_seo' => ['nullable', 'string'],
            'desc_seo' => ['nullable'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->mergeIfMissing([
            'is_feature' => false,
            'is_hot' => false,
            'posted_at' => now()->format('Y-m-d H:i'),
        ]);
    }
}
