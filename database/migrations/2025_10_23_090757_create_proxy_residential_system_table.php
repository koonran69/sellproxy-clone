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
        Schema::create('proxy_residential_orders', function (Blueprint $table) {
            $table->id();
            $table->string('partner_order_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('type', 50)->default('static');
            $table->string('service', 100)->nullable();
            $table->string('plan', 100)->nullable();
            $table->string('protocol', 50)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('isp', 100)->nullable();
            $table->integer('traffic')->default(0);
            $table->string('package', 100)->nullable();
            $table->integer('month')->default(0);
            $table->integer('quantity')->default(1);
            $table->decimal('amount', 12, 2)->default(0);
            $table->decimal('rate_vnd', 12, 2)->default(0);
            $table->json('request')->nullable();
            $table->json('partner_price_response')->nullable();
            $table->json('partner_order_response')->nullable();
            $table->json('partner_proxies_response')->nullable();
            $table->string('status', 50)->default('created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxy_residential_orders');
    }
};
