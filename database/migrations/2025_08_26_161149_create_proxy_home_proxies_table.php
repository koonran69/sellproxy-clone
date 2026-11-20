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
        Schema::create('proxy_home_proxies', function (Blueprint $table) {
            $table->id();
            $table->string('partner_order_id', 100)->index();
            $table->string('code');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('partner_item_id')->unique();

            $table->string('protocol', 20)->nullable();
            $table->string('username', 191)->nullable();
            $table->string('password', 191)->nullable();
            $table->string('ip', 100)->nullable();
            $table->unsignedInteger('port')->nullable();


            $table->string('location', 100)->nullable();
            $table->string('provider', 100)->nullable();
            $table->string('category_type_slug', 50)->nullable();
            $table->string('category_type_name', 50)->nullable();

            $table->string('ip_entity_id', 100)->nullable();
            $table->timestamp('change_ip_at')->nullable();
            $table->string('ttl', 50)->nullable();

            $table->integer('status_id')->nullable();
            $table->string('status_name', 50)->nullable();
            $table->timestamp('expired_at')->nullable();

            $table->timestamp('partner_created_at')->nullable();
            $table->timestamp('partner_updated_at')->nullable();

            $table->longText('partner_raw')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxy_home_proxies');
    }
};
