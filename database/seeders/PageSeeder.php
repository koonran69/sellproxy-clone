<?php

namespace Database\Seeders;

use App\Core\Enums\Setting\SettingTypeInput;
use App\Core\Enums\Setting\SettingGroup;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = Page::where('slug', 'gioi-thieu')->first();
        if(!$page) {
            Page::create([
               'name' => 'Giới thiệu'
            ]);
        }
    }
}
