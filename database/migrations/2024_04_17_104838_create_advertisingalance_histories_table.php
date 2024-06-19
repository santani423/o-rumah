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
        Schema::create('advertisingalance_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_type');
            $table->decimal('amount_change', 10, 2);
            $table->decimal('previous_balance', 10, 2);
            $table->decimal('current_balance', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
        // Kolom id() adalah primary key.
        // user_id adalah foreign key yang menghubungkan ke tabel users.
        // transaction_type adalah tipe transaksi (top-up, pengurangan iklan, dll.).
        // amount_change adalah jumlah perubahan saldo.
        // previous_balance adalah saldo sebelum perubahan.
        // current_balance adalah saldo setelah perubahan.
        // description adalah deskripsi tambahan tentang transaksi.
        // Tabel memiliki kolom timestamps() untuk created_at dan updated_at.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisingalance_histories');
    }
};
