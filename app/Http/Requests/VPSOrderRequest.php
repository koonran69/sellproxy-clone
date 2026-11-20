<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VPSOrderRequest extends FormRequest
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
            'os_id' => $this->os_id ? (int) $this->os_id : null,
            'os_name' => $this->os_name ?? "",

            'auto_renew' => filter_var($this->auto_renew, FILTER_VALIDATE_BOOLEAN),
            'random_password' => filter_var($this->random_password, FILTER_VALIDATE_BOOLEAN),
            'random_remote_port' => filter_var($this->random_remote_port, FILTER_VALIDATE_BOOLEAN),
            'install_chrome' => filter_var($this->install_chrome, FILTER_VALIDATE_BOOLEAN),
            'install_firefox' => filter_var($this->install_firefox, FILTER_VALIDATE_BOOLEAN),

            'coupon' => $this->coupon ?? "",
            'password' => $this->password ?? "",
            'remote_port' => $this->remote_port ?? "",
            'note' => $this->note ?? "",
            'nation' => $this->nation ?? "",

            'state' => $this->state ?? "",
            'provider' => $this->provider ?? "",
            'type' => $this->type,
        ]);
    }

    public function rules(): array
    {
        return [
            'plan_id' => 'required|integer',
            'duration' => 'required|integer',
            'auto_renew' => 'required|boolean',
            'quantity' => 'required|integer|min:1',
            'os_id' => 'nullable|integer',
            'os_name' => 'nullable|string',

            'random_password' => 'required|boolean',
            'random_remote_port' => 'required|boolean',
            'install_chrome' => 'required|boolean',
            'install_firefox' => 'required|boolean',

            'coupon' => 'nullable|string',
            'range_ip' => 'required|string',

            'state' => 'nullable|string',
            'provider' => 'nullable|string',

            'password' => 'nullable|string',
            'remote_port' => 'nullable|string',
            'nation' => 'nullable|string',
            'note' => 'nullable|string',
            'type' => 'required|in:gpu,nation',
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
