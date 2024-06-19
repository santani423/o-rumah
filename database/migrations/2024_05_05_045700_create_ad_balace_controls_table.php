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
        Schema::create('ad_balace_controls', function (Blueprint $table) {
            $table->id();// Membuat kolom ID
            $table->string('code', 255); // Membuat kolom title dengan tipe varchar(255)
            $table->string('title', 255); // Membuat kolom title dengan tipe varchar(255)
            $table->integer('nilai'); // Membuat kolom nilai dengan tipe integer
            $table->integer('klik'); // Membuat kolom nilai dengan tipe integer
            $table->text('description'); // Membuat kolom description dengan tipe text
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_balace_controls');
    }
};
