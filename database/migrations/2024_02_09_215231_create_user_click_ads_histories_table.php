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
        Schema::create('user_click_ads_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertising_points_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('ads_id')
                ->nullable()
                ->constrained('ads')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('ip_address');
            $table->string('user_agent');
            $table->timestamp('performed_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_click_ads_histories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['ads_id']);
        });
        Schema::dropIfExists('user_click_ads_histories');
    }
};
