<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Pengirim pesan
            $table->text('message')->nullable();   // Pesan teks
            $table->string('image')->nullable();   // Path untuk gambar
            $table->timestamp('sent_at');          // Waktu pengiriman pesan
            $table->timestamps();

            // Foreign key untuk user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
