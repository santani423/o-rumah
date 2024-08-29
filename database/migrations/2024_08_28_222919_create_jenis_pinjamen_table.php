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
        Schema::create('jenis_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama jenis pinjaman
            $table->text('deskripsi')->nullable(); // Deskripsi jenis pinjaman
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pinjamen');
    }
};
