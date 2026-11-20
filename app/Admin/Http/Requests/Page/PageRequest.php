<?php

namespace App\Admin\Http\Requests\Page;

use App\Core\Enums\DefaultStatus;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Http\Requests\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Enum;

class PageRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Page,id'],
            'content' => ['nullable'],
            'title_seo' => ['nullable', 'string'],
            'desc_seo' => ['nullable'],
        ];
    }

}
