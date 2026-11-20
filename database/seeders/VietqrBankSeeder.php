<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class VietqrBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $response = Http::get('https://api.vietqr.io/v2/banks');

        if($response->ok())
        {
            DB::table('vietqr_banks')->insert($response->json()['data']);
        }
    }
}
