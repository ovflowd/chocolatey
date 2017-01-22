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

namespace Azure\Controllers\AHobbaNet\AWeb;

use Azure\Types\Controller as ControllerType;
use Azure\View\Data;

class Login extends ControllerType
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
		return (Data::framework_instance(true)->page);
	}
}
