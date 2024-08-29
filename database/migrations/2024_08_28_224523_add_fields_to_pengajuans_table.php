<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPengajuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->string('jenis_pinjaman')->nullable()->after('status_pernikahan');
            $table->string('jenis_jaminan')->nullable()->after('jenis_pinjaman');
            $table->string('file_jaminan')->nullable()->after('jenis_jaminan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn('jenis_pinjaman');
            $table->dropColumn('jenis_jaminan');
            $table->dropColumn('file_jaminan');
        });
    }
}
