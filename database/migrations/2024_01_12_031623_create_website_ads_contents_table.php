<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('website_ads_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_ads_section_id')
                ->nullable()
                ->constrained('website_ads_sections')
                ->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_ads_contents');
    }
};
