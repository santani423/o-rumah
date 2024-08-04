<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserPropertyStatisticsStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_property_statistics', function (Blueprint $table) {
            // Drop the sold_rented_properties column
            $table->dropColumn('sold_rented_properties');

            // Add the new total_sold_properties column
            $table->integer('total_sold_properties')->nullable()->after('total_properties');
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
            // Re-add the sold_rented_properties column
            $table->integer('sold_rented_properties')->nullable()->after('total_properties');

            // Drop the total_sold_properties column
            $table->dropColumn('total_sold_properties');
        });
    }
}
