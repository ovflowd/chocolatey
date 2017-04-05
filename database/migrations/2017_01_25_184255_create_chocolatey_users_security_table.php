<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyUsersSecurityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_users_security', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('firstQuestion');
            $table->integer('secondQuestion');
            $table->string('firstAnswer', 50);
            $table->string('secondAnswer', 50);
            $table->primary('user_id', 'chocolatey_users_security_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_users_security');
    }
}
