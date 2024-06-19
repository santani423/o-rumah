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
        Schema::table('ads_properties', function (Blueprint $table) {
            $table->foreignId('property_type_id')->nullable()->constrained('property_types')->onDelete('set null')->after('ads_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads_properties', function (Blueprint $table) {
            $table->dropForeign(['property_type_id']);
            $table->dropColumn('property_type_id');
        });
    }
};
