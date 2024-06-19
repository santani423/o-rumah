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
        Schema::create('advertising_points', function (Blueprint $table) {
            $table->id();// Membuat kolom ID
            $table->foreignId('ad_balance_control_id'); // Foreign key ke tabel ad_balance_control
            $table->foreignId('ad_balance_id'); // Foreign key ke tabel ad_balance (asumsi tabel ini ada)
            $table->string('title', 255); // Membuat kolom title dengan tipe varchar(255)
            $table->integer('views_count'); // Membuat kolom views_count dengan tipe integer
            $table->integer('points_deducted'); // Membuat kolom points_deducted dengan tipe integer
            $table->text('description'); // Membuat kolom description dengan tipe text
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertising_points');
    }
};
