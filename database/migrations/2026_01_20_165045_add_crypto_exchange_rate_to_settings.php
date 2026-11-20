<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('settings')->insert([
            'setting_key' => 'crypto_exchange_rate',
            'setting_name' => 'Tỷ giá nạp Coin (VND/USD)',
            'plain_value' => '22000',
            'type_input' => 2,
            'group' => 60,
            'desc' => 'Tỷ giá để quy đổi từ VND sang USD khi thanh toán bằng Coin (ví dụ: 22000)'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->where('setting_key', 'crypto_exchange_rate')->delete();
    }
};
