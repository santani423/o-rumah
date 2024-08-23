<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChatIdToListGroupChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listgroupchats', function (Blueprint $table) {
            $table->unsignedBigInteger('chat_id')->nullable()->after('user_id');

            // Add a foreign key constraint if needed
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listgroupchats', function (Blueprint $table) {
            // Drop the foreign key constraint first, then the column
            $table->dropForeign(['chat_id']);
            $table->dropColumn('chat_id');
        });
    }
}
