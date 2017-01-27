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
        Schema::create('chocolatey_users_mail_requests', function (Blueprint $table) {
            $table->integer('id');
            $table->string('token', 255);
            $table->enum('used', ['0', '1'])->default('0');
            $table->string('link', 255);
            $table->integer('user_id');
            $table->primary('id', 'chocolatey_users_mail_requests_primary');
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
