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
        Schema::create('kpr_response_banks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kpr_id');
            $table->string('tanggal');
            $table->string('kodeKpr');
            $table->string('namaPengajuan');
            $table->string('noVisitor');
            $table->string('proses');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpr_response_banks');
    }
};
