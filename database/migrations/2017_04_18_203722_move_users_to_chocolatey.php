<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MoveUsersToChocolatey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chocolatey_users_id', function (Blueprint $table) {
            DB::raw('UPDATE chocolatey_users_id chocoUser INNER JOIN users arcturusUser ON chocoUser.mail = arcturusUser.mail SET chocoUser.password = users.password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Nothing to do.
    }
}
