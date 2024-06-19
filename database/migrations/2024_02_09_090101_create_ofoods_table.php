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
        Schema::create('ofoods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ads_id')
                ->nullable()
                ->constrained('ads')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('district')->nullable();
            $table->integer('districtId')->nullable();
            $table->decimal('districtLocation_lat', 10, 7)->nullable();
            $table->decimal('districtLocation_long', 10, 7)->nullable();
            $table->string('kawasan')->nullable();
            $table->string('alamat')->nullable();
            $table->longText('working_days')->nullable();
            $table->longText('image')->nullable();
            $table->string('shop_available')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ofoods', function (Blueprint $table) {
            $table->dropForeign(['ads_id']);
        });
        Schema::dropIfExists('ofoods');
    }
};
