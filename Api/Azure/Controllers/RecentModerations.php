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

use Azure\Database\Adapter;
use Azure\Models\Json\ProfileSelfies as JsonSelfies;
use Azure\Models\Json\UserChannelsContent as JsonChannelsContent;
use Azure\Types\Controller as ControllerType;
use Azure\View\Misc;

/**
 * Class RecentModerations
 * @package Azure\Controllers
 */
class RecentModerations extends ControllerType
{
	/**
	 * function construct
	 * create a controller for user-stories
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
		return '';
	}
}
