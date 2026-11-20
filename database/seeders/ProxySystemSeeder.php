<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProxySystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Proxy Types
        DB::table('proxy_line_types')->insert([
            ['name' => 'Shared', 'slug' => 'shared', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Private', 'slug' => 'private', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('ip_versions')->insert([
            ['version' => 'IPv4', 'created_at' => $now, 'updated_at' => $now],
            ['version' => 'IPv6', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
