<?php

namespace App\Admin\Http\Requests\Blog\Category;

use App\Admin\Rules\Category\CategoryParent;
use App\Core\Enums\DefaultStatus;
use App\Core\Http\Requests\Request;
use Illuminate\Validation\Rules\Enum;

class CategoryRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:App\Models\Category,id'],
            'position' => ['required', 'integer'],
            'status' => ['required', new Enum(DefaultStatus::class)],
            'description' => ['nullable'],
            'title_seo' => ['nullable'],
            'desc_seo' => ['nullable'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Category,id'],
            'name' => ['required', 'string'],
            'slug' => ['required'],
            'parent_id' => ['nullable', 'exists:App\Models\Category,id,' . $this->id],
            'position' => ['nullable', 'integer'],
            'status' => ['required', new Enum(DefaultStatus::class)],
            'description' => ['nullable'],
            'title_seo' => ['nullable'],
            'desc_seo' => ['nullable'],
            'lang' => ['nullable', 'string', 'in:vi,en'],
        ];
    }
}