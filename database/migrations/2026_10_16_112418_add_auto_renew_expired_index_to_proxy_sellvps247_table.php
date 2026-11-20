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
        Schema::table('proxy_sellvps247', function (Blueprint $table) {
            $table->index(
                ['auto_renew', 'partner_expired_at'],
                'idx_proxy247_auto_renew_expired'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proxy_sellvps247', function (Blueprint $table) {
            $table->dropIndex('idx_proxy247_auto_renew_expired');
        });
    }
};
