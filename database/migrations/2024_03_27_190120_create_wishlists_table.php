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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('ads_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('performed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['ads_id']);
        });
        Schema::dropIfExists('wishlists');
    }
};
