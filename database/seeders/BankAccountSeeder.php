<?php

namespace Database\Seeders;

use App\Core\Enums\Setting\SettingTypeInput;
use App\Core\Enums\Setting\SettingGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('settings')->where('group', SettingGroup::BankAccount)->delete();

        DB::table('settings')->insert([
            [
                'setting_key' => 'bank_account_id',
                'setting_name' => 'Ngân hàng',
                'plain_value' => 970415,
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::BankAccount,
                'desc' => 'Ngân hàng nhà băng nhà nước việt nam.'
            ],
            [
                'setting_key' => 'bank_account_no',
                'setting_name' => 'Số tài khoản',
                'plain_value' => '113366668888',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::BankAccount,
                'desc' => 'Số tài khoản ngân hàng.'
            ],

            [
                'setting_key' => 'bank_account_name',
                'setting_name' => 'Tên chủ tài khoản',
                'plain_value' => 'Nguyen Van A',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::BankAccount,
                'desc' => 'Tên chủ tài khoản ngân hàng.'
            ],

        ]);
    }
}
