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
use Azure\User;
use Azure\View\Misc;

/**
 * Class Login
 * @package Azure\Controllers\ADefault\APublic\AAuthentication
 */
class Login extends ControllerType
{
    /**
     * function construct
     * create a controller for user login
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
        User::user_login(Misc::escape_text($data['email']), Misc::escape_text($data['password']));
    }
}
