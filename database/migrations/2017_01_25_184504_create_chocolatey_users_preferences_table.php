<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyUsersPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_users_preferences', function (Blueprint $table) {
            $table->integer('user_id');
            $table->enum('emailFriendRequestNotificationEnabled', ['1', '0'])->default('0');
            $table->enum('emailGiftNotificationEnabled', ['1', '0'])->default('0');
            $table->enum('emailGroupNotificationEnabled', ['1', '0'])->default('0');
            $table->enum('emailMiniMailNotificationEnabled', ['1', '0'])->default('0');
            $table->enum('emailNewsletterEnabled', ['1', '0'])->default('0');
            $table->enum('emailRoomMessageNotificationEnabled', ['1', '0'])->default('0');
            $table->enum('friendCanFollow', ['1', '0'])->default('0');
            $table->enum('friendRequestEnabled', ['1', '0'])->default('0');
            $table->enum('offlineMessagingEnabled', ['1', '0'])->default('0');
            $table->enum('onlineStatusVisible', ['1', '0'])->default('1');
            $table->enum('profileVisible', ['1', '0'])->default('1');
            $table->primary('user_id', 'chocolatey_users_preferences_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_users_preferences');
    }
}
