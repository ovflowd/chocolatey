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

namespace Azure\Controllers\ADefault\APublic;

use Azure\Types\Controller as ControllerType;
use Azure\View\Data;

/**
 * Class Users
 * @package Azure\Controllers\ADefault\APublic
 */
class Users extends ControllerType
{
    /**
     * function construct
     * create a controller for users profile
     */

    function __construct()
    {

    }

    /**
     * function show
     * render and return content
     * @param bool $name
     * @return mixed
     */
    function show($name = false)
    {
        header('Content-type: application/json');
        $name = (($name) ? ((stripos($name, '/profile') != false) ? str_ireplace('/profile', '', $name) : $name) : false);
        return (($name) ? Data::$user_instance->get_user_data((is_numeric($name) ? 2 : 4), $name, (is_numeric($name) ? true : false)) : Data::$user_instance->get_user_data(2));
    }
}
