<?php

namespace App\Admin\Http\Requests\Voucher;

use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Http\Requests\Request;
use Carbon\Carbon;

class VoucherRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'code' => ['required', 'string'],
            'type' => ['required'],
            'value' => ['required'],
            'usage_limit' => ['nullable'],
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => ['nullable', 'date_format:Y-m-d'],
            'member_level_id' => ['nullable'],
            'user_id' => ['nullable'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Voucher,id'],
            'code' => ['required', 'string'],
            'type' => ['required'],
            'value' => ['required'],
            'usage_limit' => ['nullable'],
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => ['nullable', 'date_format:Y-m-d'],
            'member_level_id' => ['nullable'],
            'user_id' => ['nullable'],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */

    public function getStatus()
    {
        $startDate = $this->input('start_date');
        $endDate = $this->input('end_date');
        $usedCount = $this->input('used_count', 0);
        $usageLimit = $this->input('usage_limit');

        $now = Carbon::now()->format('Y-m-d');

        if (!is_null($endDate) && $endDate < $now) {
            return VoucherStatus::Expired;
        }

        if (!is_null($usageLimit) && $usedCount >= $usageLimit) {
            return VoucherStatus::Expired;
        }

        if (!is_null($startDate) && $startDate > $now) {
            return VoucherStatus::Unused;
        }

        return VoucherStatus::Used;
    }

}
