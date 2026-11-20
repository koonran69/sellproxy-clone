<?php

namespace Database\Seeders;

use App\Core\Enums\Setting\SettingTypeInput;
use App\Core\Enums\Setting\SettingGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProxyFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('settings')->where('group', SettingGroup::ProxyFeature)->delete();

        DB::table('settings')->insert([
            [
                'setting_key' => 'proxy_feature_1',
                'setting_name' => 'Proxy Feature 1',
                'plain_value' => '',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::ProxyFeature,
                'desc' => 'Proxy Feature 1'
            ],

            [
                'setting_key' => 'proxy_feature_2',
                'setting_name' => 'Proxy Feature 2',
                'plain_value' => '',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::ProxyFeature,
                'desc' => 'Proxy Feature 2'
            ],

            [
                'setting_key' => 'proxy_feature_3',
                'setting_name' => 'Proxy Feature 3',
                'plain_value' => '',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::ProxyFeature,
                'desc' => 'Proxy Feature 3'
            ],

            [
                'setting_key' => 'proxy_feature_4',
                'setting_name' => 'Proxy Feature 4',
                'plain_value' => '',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::ProxyFeature,
                'desc' => 'Proxy Feature 4'
            ],

            [
                'setting_key' => 'proxy_feature_5',
                'setting_name' => 'Proxy Feature 5',
                'plain_value' => '',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::ProxyFeature,
                'desc' => 'Proxy Feature 5'
            ],

        ]);
    }
}
