<?php

namespace App\Admin\Http\Controllers\Setting;

use App\Admin\Http\Controllers\Controller;
use App\Core\Enums\Setting\SettingGroup;
use App\Models\Setting;
use App\Models\VietqrBank;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        public Setting $model
    )
    {

    }

    public function index($group)
    {
        $settings = $this->model->getBy(filter:[
            'group' => $group
        ], sort: ['id', 'asc']);

        $breadcrums = $this->breadcrums()->add(trans('Chung'));

        return view('admin.settings.index', compact('settings', 'breadcrums'))


        ->with('input_switch', $this->model->getInputSwitch($settings));
    }

    public function bankAccount()
    {
        $settings = $this->model->getBy(filter:[
            'group' => SettingGroup::BankAccount
        ], sort: ['id', 'asc']);

        $breadcrums = $this->breadcrums()->add(trans('Cài đặt tài khoản ngân hàng'));

        return view('admin.settings.bank-account', compact('settings', 'breadcrums'))
        ->with('vietqr_banks', VietqrBank::all());
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method', 'submitter');

        if($request->has('input_switch'))
        {
            $data['input_switch'] = json_decode($data['input_switch'], true);

            foreach($data['input_switch'] as $value)
            {
                $data[$value] = isset($data[$value]);
            }

            unset($data['input_switch']);
        }

        $this->model->updateMultipleRecord($data);

        return utilities()->responseBack();
    }

    public function proxyFeature()
    {
        $settings = $this->model->getBy(filter:[
            'group' => SettingGroup::ProxyFeature
        ], sort: ['id', 'asc']);

        $breadcrums = $this->breadcrums()->add(trans('Cài đặt tính năng proxy'));
        return view('admin.settings.proxy-feature', compact('settings', 'breadcrums'));
    }

}
