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

use Azure\Controllers\AHobbaNet\AAse\Validate;
use Azure\Types\Controller as ControllerType;
use Azure\View\Data;

class Index extends ControllerType
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
		if (Validate::do_validate(1) == true):
			return (Data::framework_instance(true)->page);
		else:
			header("Location: /theallseeingeye/web/login");
			return null;
		endif;
	}
}
