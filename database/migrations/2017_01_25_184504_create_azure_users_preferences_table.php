<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAzureUsersPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('azure_users_preferences', function (Blueprint $table) {
            $table->integer('user_id', 11);
            $table->enum('emailFriendRequestNotificationEnabled', ['1', '0'])->default('0');
            $table->enum('emailGiftNotificationEnabled', ['1', '0'])->default('0');
            $table->enum('emailGroupNotificationEnabled', ['1', '0'])->default('0');
            $table->enum('emailMiniMailNotificationEnabled', ['1', '0'])->default('0');
            $table->enum('emailNewsletterEnabled', ['1', '0'])->default('0');
            $table->enum('emailRoomMessageNotificationEnabled', ['1', '0'])->default('0');
            $table->enum('friendCanFollow', ['1', '0'])->default('0');
            $table->enum('friendRequestEnabled', ['1', '0'])->default('0');
            $table->enum('offlineMessagingEnabled', ['1', '0'])->default('0');
            $table->enum('onlineStatusVisible', ['1', '0'])->default('0');
            $table->enum('profileVisible', ['1', '0'])->default('0');
            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('azure_users_preferences');
    }
}
