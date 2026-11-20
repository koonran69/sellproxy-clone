<?php

namespace App\Admin\Http\Requests\Deposit;

use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Deposit\Type;
use App\Core\Http\Requests\Request;

class DepositRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'user_id' => ['required', 'exists:App\Models\User,id'],
            'type' => ['nullable'],
            'status' => ['nullable'],
            'amount' => ['required'],
            'note' => ['nullable'],
            'code' => ['nullable'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Deposit,id'],
            'user_id' => ['required', 'exists:App\Models\User,id,' . $this->id],
            'type' => ['nullable'],
            'status' => ['nullable'],
            'amount' => ['required'],
            'note' => ['nullable'],
            'code' => ['nullable'],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */

    protected function passedValidation(): void
    {
        $data = $this->validator->getData();

        $data['code'] = 'RC' . uniqid_real();

        if (empty($data['type']) && empty($data['status'])) {
            $data['type'] = Type::Provided;
            $data['status'] = Status::Success;

        }

        $data['amount'] = str_replace('.', '', $data['amount']);
        $this->validator->setData($data);
    }
}