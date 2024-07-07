<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurasiToBosterAdsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boster_ads_t_ypes', function (Blueprint $table) {
            $table->integer('durasi')->default(1)->after('code'); // Sesuaikan 'code' dengan kolom setelah mana Anda ingin menambahkan kolom 'durasi'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boster_ads_t_ypes', function (Blueprint $table) {
            $table->dropColumn('durasi');
        });
    }
}
