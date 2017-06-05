<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyUsersMailRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_users_mail_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 255);
            $table->enum('used', ['0', '1'])->default('0');
            $table->string('link', 255);
            $table->string('mail', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_users_mail_requests');
    }
}
