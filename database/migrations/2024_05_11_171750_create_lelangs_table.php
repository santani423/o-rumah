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
        Schema::create('lelangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ads_id')
                ->nullable()
                ->constrained('ads')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('agen_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('bank_id')
                ->nullable()
                ->constrained('banks', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('kpr_name');
            $table->string('kpr_email');
            $table->string('kpr_phone');
            $table->string('agreement')->nullable();
            $table->string('image_ktp')->nullable();
            $table->string('image_kk')->nullable();
            $table->string('status')->default('pending');
            $table->text('history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lelangs');
    }
};
