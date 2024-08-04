<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserPropertyStatisticsNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_property_statistics', function (Blueprint $table) {
            // Rename the column
            // $table->renameColumn('average_price', 'total_rented_properties');

            // Modify existing columns to be nullable
            $table->bigInteger('user_id')->unsigned()->nullable()->change();
            // $table->integer('total_properties')->nullable()->change();
            $table->integer('sold_rented_properties')->nullable()->change();
            // $table->decimal('total_rented_properties', 15, 2)->nullable()->change();

            // Add new nullable columns
            $table->integer('total_active_properties')->nullable()->after('sold_rented_properties');
            $table->integer('total_inactive_properties')->nullable()->after('total_active_properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_property_statistics', function (Blueprint $table) {
            // Revert nullable changes
            $table->bigInteger('user_id')->unsigned()->nullable(false)->change();
            $table->integer('total_properties')->default(0)->nullable(false)->change();
            $table->integer('sold_rented_properties')->default(0)->nullable(false)->change();
            // $table->decimal('total_rented_properties', 15, 2)->default(0.00)->nullable(false)->change();

            // Rename the column back to the original
            // $table->renameColumn('total_rented_properties', 'average_price');

            // Drop the added columns
            $table->dropColumn('total_active_properties');
            $table->dropColumn('total_inactive_properties');
        });
    }
}
