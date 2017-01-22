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

namespace Azure\Controllers\ADefault\ASettings\APassword;

use Azure\Types\Controller as ControllerType;
use Azure\User;
use Azure\View\Data;

/**
 * Class Change
 * @package Azure\Controllers\ADefault\ASettings\APassword
 */
class Change extends ControllerType
{
    /**
     * function construct
     * create a controller for change password
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
        $data = json_decode(file_get_contents("php://input"), true);
        User::change_password($data, Data::$user_instance->user_id);
    }
}
