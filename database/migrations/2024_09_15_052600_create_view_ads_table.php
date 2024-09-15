<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address', 45);
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->timestamp('visited_at');
            $table->string('page_visited')->nullable();
            $table->unsignedBigInteger('advertising_points_id')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('advertising_points_id')->references('id')->on('advertising_points')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_ads');
    }
}
