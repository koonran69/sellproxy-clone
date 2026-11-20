<?php

namespace App\Admin\Http\Requests\User;

use App\Core\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'email' => ['required', 'email', 'unique:App\Models\User,email'],
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:App\Models\User,phone'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\User,id'],
            'email' => ['required', 'email', 'unique:App\Models\User,email,'.$this->id],
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:App\Models\User,phone,'.$this->id],
            'password' => ['nullable', 'string', 'confirmed'],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
}