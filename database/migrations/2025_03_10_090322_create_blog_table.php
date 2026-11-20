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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('_lft');
            $table->integer('_rgt');
            $table->foreignId('parent_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('feature_image')->default(false);
            $table->integer('position')->default(0);
            $table->tinyInteger('status')->nullable();
            $table->text('description')->nullable();
            $table->text('title_seo')->nullable();
            $table->text('desc_seo')->nullable();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('SET NULL');
        });
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('is_hot')->default(false);
            $table->boolean('is_feature')->default(false);
            $table->text('feature_image')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->integer('viewed')->default(0);
            $table->text('title_seo')->nullable();
            $table->text('desc_seo')->nullable();
            $table->dateTime('posted_at')->nullable();
            $table->timestamps();
        });
        Schema::create('posts_to_categories', function (Blueprint $table) {
            $table->foreignId('post_id');
            $table->foreignId('category_id');
            $table->primary(['post_id', 'category_id']);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_to_categories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('posts');
    }
};
