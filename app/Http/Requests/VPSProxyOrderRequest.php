<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VPSProxyOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'plan_id' => (int) $this->plan_id,
            'duration' => (int) $this->duration,
            'quantity' => (int) $this->quantity,
            'os_id' => (int) $this->os_id,

            'auto_renew' => filter_var($this->auto_renew, FILTER_VALIDATE_BOOLEAN),
            'random_username' => filter_var($this->random_username, FILTER_VALIDATE_BOOLEAN),
            'random_password' => filter_var($this->random_password, FILTER_VALIDATE_BOOLEAN),
            'random_remote_port' => filter_var($this->random_remote_port, FILTER_VALIDATE_BOOLEAN),
            'install_chrome' => filter_var($this->install_chrome, FILTER_VALIDATE_BOOLEAN),
            'install_firefox' => filter_var($this->install_firefox, FILTER_VALIDATE_BOOLEAN),

            'coupon' => $this->coupon ?? "",
            'username' => $this->username ?? "",
            'password' => $this->password ?? "",
            'remote_port' => $this->remote_port ?? "",
            'note' => $this->note ?? "",
            'nation' => $this->nation ?? "",

            'state' => $this->state ?? "",
            'isp' => $this->isp ?? "",
        ]);
    }

    public function rules(): array
    {
        return [
            'plan_id' => 'required|integer',
            'is_proxy' => 'required|string',
            'duration' => 'required|integer',
            'auto_renew' => 'required|boolean',
            'quantity' => 'required|integer|min:1',
            'os_id' => 'required|integer',

            'random_username' => 'required|boolean',
            'random_password' => 'required|boolean',
            'random_remote_port' => 'required|boolean',
            'install_chrome' => 'required|boolean',
            'install_firefox' => 'required|boolean',

            'coupon' => 'nullable|string',
            'range_ip' => 'required|string',

            'state' => 'nullable|string',
            'isp' => 'nullable|string',

            'username' => 'nullable|string',
            'password' => 'nullable|string',
            'remote_port' => 'nullable|string',
            'nation' => 'nullable|string',
            'note' => 'nullable|string',
            'proxy_type' => 'required',
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
