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

namespace Azure\Controllers\ADefault\AUser;

use Azure\Types\Controller as ControllerType;
use Azure\View\Data;

/**
 * Class Preferences
 * @package Azure\Controllers\ADefault\AUser
 */
class Preferences extends ControllerType
{
    /**
     * function construct
     * create a controller for discussions
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
        return json_encode(Data::$user_instance->user_preferences);
    }
}
