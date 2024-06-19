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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->mediumText('description')->nullable();
            $table->string('type')->default('property');
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('points')->nullable();//menentukan jumlab boster
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->string('status')->nullable();
            $table->string('history')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('ads');
    }
};
