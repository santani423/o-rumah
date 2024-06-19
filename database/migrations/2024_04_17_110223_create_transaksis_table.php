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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID pengguna yang melakukan transaksi 
            $table->unsignedBigInteger('payment_id'); // ID pengguna yang melakukan transaksi 
            $table->string('payment_method'); // Metode pembayaran
            $table->string('payment_status')->default('pending'); // Status pembayaran
            $table->decimal('amount', 10, 2); // Jumlah pembayaran
            $table->timestamp('transaction_time')->nullable(); // Waktu transaksi
            $table->text('description')->nullable(); // Deskripsi transaksi
            $table->text('additional_info')->nullable(); // Informasi tambahan
            $table->string('transaction_status')->default('pending'); // Status transaksi
            $table->longText('proof_of_transaction')->nullable(); // Bukti transaksi (lokasi file atau informasi terkait)
            $table->timestamps(); // Kolom created_at dan updated_at

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
