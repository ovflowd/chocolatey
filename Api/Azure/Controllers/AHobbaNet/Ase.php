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

namespace Azure\Controllers\AHobbaNet;

use Azure\Types\Controller as ControllerType;

/**
 * Class Notifications
 * @package Azure\Controllers
 */
class Ase extends ControllerType
{
    /**
     * function construct
     * create a controller for notifications
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
        header("Location: /theallseeingeye/web/login");
    }
}