<?php

namespace App\Admin\Http\Requests\Coin;

use App\Core\Enums\DefaultStatus;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Http\Requests\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Enum;

class CoinRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'coin_name' => ['required', 'string'],
            'code' => ['required', 'string'],
            'status' => ['required', new Enum(DefaultStatus::class)],
            'icon' => ['required', 'string']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Coin,id'],
            'coin_name' => ['required', 'string'],
            'status' => ['required', new Enum(DefaultStatus::class)],
            'icon' => ['required', 'string']
        ];
    }

}
