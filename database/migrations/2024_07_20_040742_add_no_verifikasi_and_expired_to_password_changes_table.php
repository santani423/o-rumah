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
        Schema::table('password_changes', function (Blueprint $table) {
            $table->string('noVerifikasi')->after('uuid');
            $table->timestamp('expired')->after('noVerifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_changes', function (Blueprint $table) {
            $table->dropColumn('noVerifikasi');
            $table->dropColumn('expired');
        });
    }
};
