<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Admin::create([
            'username' => 'ktech',
            'fullname' => 'K Tech Admin',
            'email' => 'admin@k-tech.net.vn',
            'status' => 1,
            'is_superadmin' => true,
            'password' => '123456'
        ]);

        $this->call([
            SettingSeeder::class,
            VietqrBankSeeder::class,
            BankAccountSeeder::class
        ]);
    }
}
