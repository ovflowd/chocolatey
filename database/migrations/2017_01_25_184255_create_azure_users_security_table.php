<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAzureUsersSecurityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('azure_users_security', function (Blueprint $table) {
            $table->integer('user_id', 11);
            $table->integer('firstQuestion', 2);
            $table->integer('secondQuestion', 2);
            $table->string('firstAnswer', 50);
            $table->string('secondAnswer', 50);
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
        Schema::dropIfExists('azure_users_security');
    }
}
