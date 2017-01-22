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

namespace Azure\Controllers;

use Azure\Types\Controller as ControllerType;
use Azure\View\Data;

/**
 * Class Profile
 * @package Azure\Controllers
 */
class Profile extends ControllerType
{
	/**
	 * function construct
	 * create a controller for user profile
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
		header('Content-type: application/json');
		return Data::$user_instance->get_user_data(2);
	}
}