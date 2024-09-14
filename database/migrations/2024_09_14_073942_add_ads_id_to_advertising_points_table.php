<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdsIdToAdvertisingPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertising_points', function (Blueprint $table) {
            $table->unsignedBigInteger('ads_id')->nullable()->after('id'); // Menambahkan kolom ads_id setelah kolom id
            $table->foreign('ads_id')->references('id')->on('ads')->onDelete('set null'); // Menambahkan foreign key dari tabel ads
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertising_points', function (Blueprint $table) {
            $table->dropForeign(['ads_id']);
            $table->dropColumn('ads_id');
        });
    }
}

