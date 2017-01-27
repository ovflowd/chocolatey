<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAzureUsersPhotosLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_users_photos_likes', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('photo_id');
            $table->string('username', 255);
            $table->primary('id', 'chocolatey_users_photos_likes_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_users_photos_likes');
    }
}
