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

namespace Azure\Controllers\ADefault\ASettings\AEMail;

use Azure\Types\Controller as ControllerType;
use Azure\User;
use Azure\View\Data;

/**
 * Class Change
 * @package Azure\Controllers\ADefault\ASettings\AEMail
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
        header('Content-type: application/json; charset=utf-8');
        $data = json_decode(file_get_contents("php://input"), true);
        $data['password'] = '';
        User::change_email($data, Data::$user_instance->user_id);
    }
}
