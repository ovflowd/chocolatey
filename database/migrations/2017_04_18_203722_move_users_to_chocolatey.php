<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MoveUsersToChocolatey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::raw('UPDATE chocolatey_users_id chocoUser INNER JOIN users arcturusUser ON chocoUser.mail = arcturusUser.mail SET chocoUser.password = users.password');
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
