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
        Schema::create('proxy_sellvps247_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->integer('duration')->default(0);
            $table->tinyInteger('auto_renew');
            $table->integer('quantity')->default(0);
            $table->string('coupon', 100)->nullable();
            $table->string('range_ip', 191)->nullable();
            $table->text('nation')->nullable();
            $table->string('state', 191)->nullable();
            $table->string('isp', 191)->nullable();
            $table->string('username', 191)->nullable();
            $table->string('password', 191)->nullable();
            $table->integer('remote_port')->default(0);
            $table->decimal('price', 12, 2)->default(0);
            $table->json('request')->nullable();
            $table->json('partner_price_response')->nullable();
            $table->json('partner_order_response')->nullable();
            $table->string('status', 50)->default('created');
            $table->timestamps();
        });

        Schema::create('proxy_sellvps247', function (Blueprint $table) {
            $table->id();
            $table->string('proxy_id',100)->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreignId('order_id')->constrained('proxy_sellvps247_orders')->cascadeOnDelete();

            $table->string('server_name',191)->nullable();
            $table->string('template',191)->nullable();
            $table->string('ram',191)->nullable();
            $table->string('cpu',191)->nullable();
            $table->string('ssd',191)->nullable();
            $table->string('country',100)->nullable();
            $table->string('region',100)->nullable();
            $table->string('PlanName',100)->nullable();
            $table->integer('change_ip_time')->default(0);
            $table->text('note')->nullable();
            $table->timestamp('partner_created_at')->nullable();
            $table->timestamp('partner_expired_at')->nullable();
            $table->string('networkType', 191)->nullable();
            $table->string('publicIp', 191)->nullable();
            $table->string('connectIp', 191)->nullable();
            $table->string('httpPort', 191)->nullable();
            $table->string('httpsPort', 191)->nullable();
            $table->string('socks5Port', 191)->nullable();

            $table->string('name',191)->nullable();
            $table->string('ip', 191)->nullable();
            $table->string('username', 191)->nullable();
            $table->string('password', 191)->nullable();
            $table->integer('remote_port')->default(0);
            $table->decimal('amount_before', 12, 2)->default(0);
            $table->decimal('amount_last', 12, 2)->default(0);
            $table->decimal('price', 12, 2)->default(0);
            $table->tinyInteger('auto_renew');

            $table->string('state', 191)->nullable();
            $table->string('isp', 191)->nullable();
            $table->string('status', 50)->default('Active');

            $table->json('partner_server_info_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxy_sellvps247_orders');
        Schema::dropIfExists('proxy_sellvps247');
    }
};
