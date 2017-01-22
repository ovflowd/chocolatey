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

namespace Azure\Controllers\ADefault\APublic\AAuthentication;

use Azure\Types\Controller as ControllerType;

/**
 * Class Logout
 * @package Azure\Controllers\ADefault\APublic\AAuthentication
 */
class Logout extends ControllerType
{
    /**
     * function construct
     * create a controller for user logout
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
        header('HTTP/1.1 204 No Content');
        session_destroy();
    }
}
