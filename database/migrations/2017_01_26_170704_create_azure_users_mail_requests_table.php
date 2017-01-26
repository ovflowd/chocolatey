<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAzureUsersMailRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('azure_users_mail_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 255);
            $table->enum('used', ['0', '1'])->default('0');
            $table->string('link', 255);
            $table->integer('user_id', 11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('azure_users_mail_requests');
    }
}
