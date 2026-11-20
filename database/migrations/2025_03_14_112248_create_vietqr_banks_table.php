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
        Schema::create('vietqr_banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('bin');
            $table->string('shortName');
            $table->string('logo')->nullable();
            $table->string('short_name')->nullable();
            $table->string('support')->nullable();
            $table->string('isTransfer')->nullable();
            $table->string('swift_code')->nullable();
            $table->boolean('transferSupported')->nullable();
            $table->boolean('lookupSupported')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vietqr_banks');
    }
};
