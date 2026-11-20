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
        Schema::create('proxy_residential_proxies', function (Blueprint $table) {
            $table->id();
            $table->string('partner_order_id', 100)->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreignId('pr_order_id')->constrained('proxy_residential_orders')->cascadeOnDelete();

            $table->text('proxy_id')->nullable();
            $table->string('proxy_status', 20)->nullable();
            $table->string('networkType', 191)->nullable();
            $table->json('authentication')->nullable();
            $table->string('username', 191)->nullable();
            $table->string('password', 191)->nullable();

            $table->json('connection')->nullable();
            $table->string('publicIp', 191)->nullable();
            $table->string('connectIp', 191)->nullable();
            $table->string('httpPort', 191)->nullable();
            $table->string('httpsPort', 191)->nullable();
            $table->string('socks5Port', 191)->nullable();
            $table->json('hostnames')->nullable();

            $table->string('proxyType', 191)->nullable();
            $table->timestamp('partner_createdAt')->nullable();
            $table->timestamp('partner_expiresAt')->nullable();
            $table->text('note')->nullable();
            $table->json('metadata')->nullable();

            $table->json('partner_proxies_response')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxy_residential_proxies');
    }
};
