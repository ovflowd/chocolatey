<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyUsersIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_users_id', function (Blueprint $table) {
            $table->string('mail', 125);
            $table->integer('user_id');
            $table->enum('mail_verified', ['0', '1'])->default('0');
            $table->primary('user_id', 'chocolatey_users_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_users_id');
    }
}
