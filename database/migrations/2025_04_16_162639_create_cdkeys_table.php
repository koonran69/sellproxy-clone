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
        Schema::create('cdkeys', function (Blueprint $table) {
            $table->id();
            $table->text('cdkey');
            $table->integer('proxy_id');
            $table->integer('variation_id');
            $table->integer('attr_id');
            $table->tinyInteger('is_notify')->nullable()->default(0);
            $table->tinyInteger('is_use')->nullable()->default(0);
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cdkeys');
    }
};
