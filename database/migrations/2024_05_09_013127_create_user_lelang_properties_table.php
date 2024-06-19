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
        Schema::create('user_lelang_properties', function (Blueprint $table) {
            $table->id();  // Membuat kolom ID yang juga merupakan primary key yang auto-increment.
            $table->foreignId('user_id');  // Membuat foreign key 'user_id' yang terhubung dengan tabel users. Jika user dihapus, data terkait juga akan dihapus.
            $table->foreignId('property_id');  // Membuat foreign key 'property_id' yang terhubung dengan tabel properties. Jika property dihapus, data terkait juga akan dihapus.
            $table->foreignId('ads_id');  // Membuat foreign key 'ads_id' yang terhubung dengan tabel advertisements. Jika iklan dihapus, data terkait juga akan dihapus.
            $table->boolean('is_active')->default(false); // Membuat kolom 'is_active' untuk menyimpan status lelang (misalnya: aktif, selesai, dibatalkan).
            $table->decimal('bid_amount', 10, 2)->nullable();  // Membuat kolom 'bid_amount' untuk menyimpan jumlah tawaran dengan presisi 10 digit dan 2 digit desimal.
            $table->boolean('winning_bid')->default(false);  // Membuat kolom 'winning_bid' untuk menandai apakah tawaran ini adalah tawaran pemenang. Defaultnya adalah false.
            $table->timestamps();  // Membuat kolom 'created_at' dan 'updated_at' untuk mencatat waktu pembuatan dan pembaruan data.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_lelang_properties');
    }
};
