<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankColumnsToPengajuansTable extends Migration
{
    public function up()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_umum_id')->nullable()->after('status_pernikahan');
            $table->unsignedBigInteger('bank_bpr_id')->nullable()->after('bank_umum_id');
        });
    }

    public function down()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn('bank_umum_id');
            $table->dropColumn('bank_bpr_id');
        });
    }
}
