<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAzurePhotosLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('azure_user_photos_likes', function (Blueprint $table) {
            $table->integer('id', 11);
            $table->integer('photo_id', 11);
            $table->string('username', 255);
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('azure_user_photos_likes');
    }
}
