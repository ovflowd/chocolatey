<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAzureUsersPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_users_photos', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('creator_id');
            $table->string('previewUrl', 255);
            $table->string('url', 255);
            $table->timestamp('time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('tags', 255);
            $table->string('creator_name', 50);
            $table->integer('version')->default(1);
            $table->enum('type', ["PHOTO", "SELFIE"])->default("PHOTO");
            $table->integer('room_id');
            $table->primary('id', 'chocolatey_users_photos_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_users_photos');
    }
}
