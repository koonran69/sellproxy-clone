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
        Schema::create('proxy_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('external_order_id')->nullable();
            $table->integer('country_id');
            $table->unsignedTinyInteger('ip_version_id');
            $table->unsignedTinyInteger('type_id');
            $table->integer('quantity');
            $table->integer('period_days');
            $table->decimal('total_amount', 12, 2);
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->timestamps();
        });

        Schema::create('proxy_instances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('proxy_order_id');
            $table->bigInteger('proxyline_id');
            $table->string('ip');
            $table->string('internal_ip')->nullable();
            $table->integer('port_http');
            $table->integer('port_socks5');
            $table->string('username');
            $table->string('password');
            $table->string('country_code', 2);
            $table->unsignedTinyInteger('type');
            $table->unsignedTinyInteger('ip_version');
            $table->string('order_id');
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->json('raw_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxy_instances');
        Schema::dropIfExists('proxy_orders');
    }
};
