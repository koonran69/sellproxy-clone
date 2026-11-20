<?php

namespace App\Admin\Http\Requests\QA;

use App\Core\Enums\DefaultStatus;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Http\Requests\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Enum;

class QARequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'question' => ['required', 'string'],
            'answer' => ['nullable'],
            'status' => ['required', new Enum(DefaultStatus::class)],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\QA,id'],
            'question' => ['required', 'string'],
            'answer' => ['nullable'],
            'status' => ['required', new Enum(DefaultStatus::class)],
        ];
    }

}
