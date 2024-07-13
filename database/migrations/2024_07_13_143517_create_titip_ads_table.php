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
        Schema::create('titip_ads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ads_id');
            $table->bigInteger('user_owner_id');
            $table->bigInteger('user_receiver_id');
            $table->string('status')->default('pending');//pandding//approval//reject
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titip_ads');
    }
};
