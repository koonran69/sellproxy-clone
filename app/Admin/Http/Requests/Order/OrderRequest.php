<?php

namespace App\Admin\Http\Requests\Order;

use App\Core\Http\Requests\Request;

class OrderRequest extends Request
{

    protected function methodGet()
    {
        if ($this->routeIs('admin.order.render_info_user')) {
            return [
                'user_id' => ['required', 'exists:App\Models\User,id']
            ];
        } elseif ($this->routeIs('admin.order.add_product')) {
            return [
                // 'user_id' => ['required', 'exists:App\Models\User,id'],
                'product_id' => ['required', 'exists:App\Models\Proxy,id'],
                'product_variation_id' => ['nullable', 'exists:App\Models\ProxyVariation,id'],
            ];
        }
        return [

        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'user_id' => ['required', 'exists:App\Models\User,id'],
            'note' => ['nullable'],
            'email_notify' => ['nullable'],

            'data.product_id' => ['required', 'array'],
            'data.product_id.*' => ['exists:App\Models\Proxy,id'],

            'data.variation_id' => ['required', 'array'],
            'data.variation_id.*' => ['exists:App\Models\ProxyVariation,id'],

            'data.quantity' => ['required', 'array'],
            'data.quantity.*' => ['integer', 'min:1'],

            'data.price' => ['required', 'array'],
            'data.price.*' => ['numeric', 'min:0'],

            'data.price_promotion' => ['nullable', 'array'],
            'data.price_promotion.*' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Order,id'],
            'status' => ['required']
        ];
    }

    /**
     * Handle a passed validation attempt.
     */

}