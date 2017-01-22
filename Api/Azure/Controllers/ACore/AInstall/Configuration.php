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

namespace Azure\Controllers\ACore\AInstall;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;

/**
 * Class Configuration
 * @package Azure\Controllers\ACore\AInstall
 */
class Configuration extends ControllerType
{

	/**
	 * function construct
	 * create a controller for shop purse
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
		if (!INSTALLED):
			if (file_exists(ROOT_PATH . '/Api/Gogo.php')):
				unlink(ROOT_PATH . '/Api/Init.php');
				rename(ROOT_PATH . '/Api/Gogo.php', ROOT_PATH . '/Api/Init.php');
				return '<p>Installation 60% Done.. Please Click to Continue.<input class="confirm-button" onclick="document.location.href=\'/installation\'" type="submit" value="Next"></p>';
			else:
				Adapter::set_instance(unserialize(DATABASE_SETTINGS));
				$i = Adapter::get_instance();
				$i->exec(file_get_contents(ROOT_PATH . '/Etc/cms_sql/sql.sql'));
				return '<p>Installation Successfully! <input class="confirm-button" onclick="document.location.href=\'/administration\'" type="submit" value="Next"></p>';
			endif;
		endif;
		header("Location: /");
		return;
	}
}