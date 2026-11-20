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
        Schema::create('proxy_line_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('ip_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->timestamps();
        });

        Schema::create('proxy_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10);
            $table->string('feature_image')->nullable();
            $table->timestamps();
        });

        Schema::create('proxy_country_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('proxy_countries')->onDelete('cascade');
            $table->foreignId('proxy_type_id')->constrained('proxy_types')->onDelete('cascade');
            $table->foreignId('ip_version_id')->constrained('ip_versions')->onDelete('cascade');
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->unique(['country_id', 'proxy_type_id', 'ip_version_id'], 'unique_availability');
        });

        Schema::create('proxy_price_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proxy_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('ip_version_id')->constrained()->onDelete('cascade');
            $table->integer('duration_days'); // 5, 30, 90, 365
            $table->integer('min_quantity');
            $table->integer('max_quantity');
            $table->decimal('price_per_ip', 10, 2);
            $table->timestamps();

            $table->unique([
                'proxy_type_id',
                'ip_version_id',
                'duration_days',
                'min_quantity',
                'max_quantity'
            ], 'unique_proxy_price_tier');
        });

        Schema::create('proxy_price_tier_countries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proxy_price_tier_id')->constrained('proxy_price_tiers')->onDelete('cascade');
            $table->foreignId('country_id')->constrained('proxy_countries')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['proxy_price_tier_id', 'country_id'], 'unique_tier_country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxy_price_tier_countries');
        Schema::dropIfExists('proxy_price_tiers');
        Schema::dropIfExists('proxy_country_availabilities');
        Schema::dropIfExists('proxy_countries');
        Schema::dropIfExists('ip_versions');
        Schema::dropIfExists('proxy_line_types');
    }
};
