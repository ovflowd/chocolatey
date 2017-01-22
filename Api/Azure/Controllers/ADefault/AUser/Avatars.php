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

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\User;
use Azure\View\Data;

/**
 * Class Avatars
 * @package Azure\Controllers\ADefault\AUser
 */
class Avatars extends ControllerType
{
    /**
     * function construct
     * create a controller for campaigns
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
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['name'])):
            User::register_user($data, true);
            return null;
        endif;

        $user_mail = Data::$user_instance->user_email;
        $master = [];

        foreach (Adapter::secure_query("SELECT username FROM users WHERE mail = :usermail", [':usermail' => $user_mail]) as $row)
            $master[] = json_decode(Data::$user_instance->get_user_data(4, $row['username']), true);

        return json_encode($master);
    }
}
