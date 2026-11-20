<?php

namespace Database\Seeders;

use App\Core\Enums\Setting\SettingTypeInput;
use App\Core\Enums\Setting\SettingGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('settings')->truncate();

        DB::table('settings')->insert([
            [
                'setting_key' => 'site_name',
                'setting_name' => 'Tên site',
                'plain_value' => 'Seo KTech',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::General,
                'desc' => 'Tên của website, shop, app'
            ],
            [
                'setting_key' => 'site_logo',
                'setting_name' => 'Logo',
                'plain_value' => '/core/assets/images/logo.png',
                'type_input' => SettingTypeInput::Image,
                'group' => SettingGroup::General,
                'desc' => 'Logo thương hiệu'
            ],
            [
                'setting_key' => 'hotline',
                'setting_name' => 'Số điện thoại',
                'plain_value' => '0999999999',
                'type_input' => SettingTypeInput::Phone,
                'group' => SettingGroup::General,
                'desc' => 'Số điện thoại liên lạc.'
            ],
            [
                'setting_key' => 'Email',
                'setting_name' => 'Email',
                'plain_value' => 'proxy@gmail.com',
                'type_input' => SettingTypeInput::Email,
                'group' => SettingGroup::General,
                'desc' => 'Địa chỉ email liên lạc.'
            ],
            [
                'setting_key' => 'address',
                'setting_name' => 'Địa chỉ',
                'plain_value' => 'Phường 25, Quận Bình Thạnh, TP HCM',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::General,
                'desc' => 'Địa chỉ liên lạc.'
            ],

            //socail
            [
                'setting_key' => 'faccebook',
                'setting_name' => 'Facebook',
                'plain_value' => '',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::Social,
                'desc' => 'Link facebook.'
            ],

            [
                'setting_key' => 'youtube',
                'setting_name' => 'Youtube',
                'plain_value' => '',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::Social,
                'desc' => 'Link youtube.'
            ],

            [
                'setting_key' => 'linkedin',
                'setting_name' => 'Linkedin',
                'plain_value' => '',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::Social,
                'desc' => 'Link linkedin.'
            ]
        ]);
    }
}
