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
        Schema::create('wilayah_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('district_id')->nullable();
            $table->string('district_name')->nullable(); 
            $table->string('lat')->nullable(); 
            $table->string('lng')->nullable(); 
            $table->string('area')->nullable(); 
            $table->string('address')->nullable(); 
            $table->string('location')->nullable(); 
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah_kerjas');
    }
};
