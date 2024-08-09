<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_usage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('referral_code_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->boolean('reward_granted')->default(false);

            $table->foreign('referral_code_id')->references('id')->on('referral_codes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_usage');
    }
}

