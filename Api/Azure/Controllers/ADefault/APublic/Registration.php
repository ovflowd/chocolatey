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
use Azure\User;
use Azure\View\Misc;

/**
 * Class Registration
 * @package Azure\Controllers\ADefault\APublic
 */
class Registration extends ControllerType
{
    /**
     * function construct
     * create a controller for user registration
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
        $generated_user = User::generate_newbie_username(Misc::escape_text($data['email']));
        User::register_user(['username' => $generated_user, 'password' => Misc::escape_text($data['password']), 'email' => Misc::escape_text($data['email'])]);
    }
}
