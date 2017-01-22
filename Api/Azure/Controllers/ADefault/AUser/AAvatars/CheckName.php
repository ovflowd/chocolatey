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

namespace Azure\Controllers\ADefault\AUser\AAvatars;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\View\Data;
use Azure\View\Misc;
use stdClass;

/**
 * Class Avatars
 * @package Azure\Controllers\ADefault\AUser
 */
class CheckName extends ControllerType
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
     * @param string $user_name
     * @return mixed|void
     */
    function show($user_name = '')
    {
        header('Content-type: application/json');

        $is_available = false;

        if (isset($user_name)):
            $name = Misc::escape_text($user_name);
            if (((strlen($name) >= 3) && (strlen($name) <= 30)) && (preg_match('`[a-z]`', $name)) && (substr_count($name, ' ') == 0) && (stripos($name, 'MOD_') === false))
                if ((Adapter::row_count(Adapter::secure_query("SELECT username FROM users WHERE username = :username LIMIT 1", [':username' => $name])) == 0) || ($name == Data::$user_instance->user_name))
                    $is_available = true;
        endif;

        $available_object = new stdClass();
        $available_object->isAvailable = $is_available;

        return json_encode($available_object);
    }
}
