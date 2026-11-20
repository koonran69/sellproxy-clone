<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proxy_home_proxies', function (Blueprint $table) {
            $table->index(
                ['auto_renew', 'expired_at'],
                'idx_proxy_home_auto_renew_expired'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proxy_home_proxies', function (Blueprint $table) {
            $table->dropIndex('idx_proxy_home_auto_renew_expired');
        });
    }
};
