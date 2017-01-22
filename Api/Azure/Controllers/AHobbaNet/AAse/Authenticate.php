<?php

/*
 * * azure project presents:
                                          _
                                         | |
 __,   __          ,_    _             _ | |
/  |  / / _|   |  /  |  |/    |  |  |_|/ |/ \_
\_/|_/ /_/  \_/|_/   |_/|__/   \/ \/  |__/\_/
        /|
        \|
				azure web
				version: 1.0a
				azure team
 * * be carefully.
 */

namespace Azure\Controllers\AHobbaNet\AAse;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\View\Misc;

class Authenticate extends ControllerType
{
	/**
	 * function construct
	 * create a controller for promos
	 */

	function __construct()
	{

	}

	/**
	 * function show
	 * render and return content
	 */
	function show()
	{
		@session_start();
		$username = Misc::escape_text($_POST['username']);
		$password = Misc::escape_text($_POST['password']);
		if (Adapter::row_count(Adapter::secure_query("SELECT * FROM cms_hk_users WHERE username = MD5(:username) AND password = MD5(:password)", [':username' => $username, ':password' => $password])) == 1):
			$hash = md5((rand(10, 30 . '-ase-' . rand(40, 60) . '-ase-' . rand(80, 90))));
			Adapter::secure_query("UPDATE cms_hk_users SET hash = :hash WHERE username = MD5(:username)", [':hash' => $hash, ':username' => $username]);
			$row                  = Adapter::fetch_array(Adapter::secure_query("SELECT rank FROM cms_hk_users WHERE username = MD5(:username)", [':username' => $username]));
			$arr                  = [
				'username' => $username,
				'hash' => $hash,
				'rank' => $row['rank']
			];
			$_SESSION['hobbanet'] = serialize($arr);
			header("Location: /theallseeingeye/web/index");
			return;
		else:
			session_destroy();
			header("Location: /theallseeingeye/web/?fail");
			return;
		endif;
	}
}
