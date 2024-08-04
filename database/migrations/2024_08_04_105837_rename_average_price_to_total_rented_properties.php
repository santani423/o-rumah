<?php

 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAveragePriceToTotalRentedProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_property_statistics', function (Blueprint $table) {
            // Rename average_price to total_rented_properties by adding the new column
            // and dropping the old one (workaround for renameColumn)
            $table->decimal('total_rented_properties', 15, 2)->nullable()->after('sold_rented_properties');
            $table->dropColumn('average_price');

            // Ensure all fields except 'id' can be nullable
            $table->bigInteger('user_id')->unsigned()->nullable()->change();
            $table->integer('total_properties')->nullable()->change();
            $table->integer('sold_rented_properties')->nullable()->change();
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
            // Revert the changes by creating average_price again and removing total_rented_properties
            $table->decimal('average_price', 15, 2)->default(0.00)->nullable(false)->after('sold_rented_properties');
            $table->dropColumn('total_rented_properties');

            // Revert nullable changes
            $table->bigInteger('user_id')->unsigned()->nullable(false)->change();
            $table->integer('total_properties')->default(0)->nullable(false)->change();
            $table->integer('sold_rented_properties')->nullable(false)->change();
        });
    }
}
