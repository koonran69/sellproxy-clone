<?php

namespace App\Admin\Http\Requests\MemberLevel;

use App\Core\Http\Requests\Request;

class MemberLevelRequest extends Request
{
    protected function methodPost()
    {
        return [
            'name' => ['required','string','max:255'],
            'plain_value' => ['required', 'numeric'],
            'position' => ['required', 'integer', 'min:0'],
            'feature_image' => ['nullable'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required','exists:App\Models\MemberLevel,id'],
            'name' => ['required','string','max:255'],
            'plain_value' => ['required', 'numeric'],
            'position' => ['required', 'integer', 'min:0'],
            'feature_image' => ['nullable'],
        ];
    }
}