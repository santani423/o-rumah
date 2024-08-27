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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_pengajuan_id')->constrained('type_pengajuans');
            $table->string('code_pengajuan')->unique();
            $table->string('nomor_pengajuan')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('pekerjaan')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('email')->nullable();
            $table->string('no_tlp')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('ktp')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('surat_nikah_atau_cerai')->nullable();
            $table->string('rekening_koran')->nullable();
            $table->string('slip_gaji')->nullable();
            $table->string('agreement')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_pengajuan');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
