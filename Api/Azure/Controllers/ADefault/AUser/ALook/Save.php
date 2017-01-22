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

namespace Azure\Controllers\ADefault\AUser\ALook;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\View\Data;
use Azure\View\Misc;

/**
 * Class Save
 * @package Azure\Controllers\ADefault\AUser\ALook
 */
class Save extends ControllerType
{
    /**
     * function construct
     * create a controller for save look
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
        if (!isset($_SESSION['is_newbie']))
            return null;

        $data = json_decode(file_get_contents("php://input"), true);

        Adapter::secure_query("UPDATE users SET look = :look, gender = :gender WHERE id = :userid", [':look' => Misc::escape_text($data['figure']), ':gender' => Misc::escape_text($data['gender']), ':userid' => Data::$user_instance->user_id]);

        header('Content-type: application/json');
        return '[' . Data::$user_instance->get_user_data(4) . ']';
    }
}
