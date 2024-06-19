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
        Schema::create('plans_transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksis_id');
            $table->unsignedBigInteger('plans_id');
            $table->unsignedBigInteger('price');
            $table->text('description');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans_transaksis');
    }
};
