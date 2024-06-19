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
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('company_id');
            $table->string('company_image')->nullable()->after('company_name');

            $table->string('bank_name')->nullable()->after('company_image');
            $table->string('bank_number')->nullable()->after('bank_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'company_image', 'bank_name', 'bank_number']);
        });
    }
};
