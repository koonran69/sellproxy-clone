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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->char('code');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('type')->default(10);
            $table->double('amount')->nullable();
            $table->tinyInteger('status')->default(10);
            $table->text('note')->nullable();
            $table->json('data')->nullable();
            $table->timestamp('last_check')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
