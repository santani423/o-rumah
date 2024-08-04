<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTotalRentedPropertiesToInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_property_statistics', function (Blueprint $table) {
            // Change the total_rented_properties column type from decimal to integer
            $table->integer('total_rented_properties')->nullable()->change();
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
            // Revert the total_rented_properties column type back to decimal
            $table->decimal('total_rented_properties', 15, 2)->nullable()->change();
        });
    }
}
