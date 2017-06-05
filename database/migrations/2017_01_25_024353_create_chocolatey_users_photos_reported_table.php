<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyUsersPhotosReportedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_users_photos_reported', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('photo_id');
            $table->integer('reported_by');
            $table->integer('reason_id');
            $table->enum('approved', ['0', '1', '2'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_users_photos_reported');
    }
}
