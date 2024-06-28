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
        Schema::create('boster_ads_t_ypes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255);
            $table->string('slug', 255);
            $table->string('type', 255);
            $table->string('title', 255);
            $table->unsignedBigInteger('limit');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boster_ads_t_ypes');
    }
};
