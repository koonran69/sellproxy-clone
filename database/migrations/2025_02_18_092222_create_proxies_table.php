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

        Schema::create('proxy_categories', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->nullable();
            $table->integer('position')->default(0);
            $table->text('feature_image')->nullable();
            $table->timestamps();
        });

        Schema::create('proxy_types', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->nullable();
            $table->integer('position')->default(0);
            $table->text('feature_image')->nullable();
            $table->timestamps();
        });

        Schema::create('proxies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('name');
            $table->string('sub_title')->nullable();
            $table->string('slug')->unique();
            $table->text('short_desc')->nullable();
            $table->text('desc')->nullable();
            $table->text('feature_image')->nullable();
            $table->double('price')->nullable();
            $table->double('price_promotion')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('proxy_categories')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('proxy_types')->onDelete('cascade');
        });

        Schema::create('attributes', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('position')->default(0);
            $table->text('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('variations', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attr_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('position')->default(0);
            $table->text('desc')->nullable();
            $table->timestamps();
            $table->foreign('attr_id')->references('id')->on('attributes')->onDelete('cascade');
        });


        Schema::create('proxy_variations', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proxy_id');
            $table->unsignedBigInteger('variation_id');
            $table->double('price')->nullable();
            $table->double('price_promotion')->nullable();
            $table->string('duration')->nullable();
            $table->string('status')->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
            $table->foreign('proxy_id')->references('id')->on('proxies')->onDelete('cascade');
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxy_categories');
        Schema::dropIfExists('proxies');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('variations');
        Schema::dropIfExists('proxy_variations');
    }
};
