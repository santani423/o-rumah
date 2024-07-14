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
        Schema::table('titip_ads', function (Blueprint $table) {
            $table->bigInteger('new_ads_id')->nullable()->after('user_receiver_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titip_ads', function (Blueprint $table) {
            $table->dropColumn('new_ads_id');
        });
    }
};
