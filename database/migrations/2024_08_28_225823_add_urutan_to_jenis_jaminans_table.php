<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrutanToJenisJaminansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_jaminans', function (Blueprint $table) {
            $table->integer('urutan')->after('deskripsi')->nullable(); // Menambahkan kolom urutan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_jaminans', function (Blueprint $table) {
            $table->dropColumn('urutan'); // Menghapus kolom urutan jika migrasi dibatalkan
        });
    }
}
