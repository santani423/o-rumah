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
        Schema::create('email_banks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bank_id');
            $table->string('email', 255);
            $table->enum('email_type', ['kpr', 'lelang', 'lainnya']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_banks');
    }
};

