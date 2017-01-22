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

namespace Azure\Controllers\ADefault\AUser\APreferences;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\View\Data;

/**
 * Class Preferences
 * @package Azure\Controllers\ADefault\AUser
 */
class Save extends ControllerType
{
    /**
     * function construct
     * create a controller for discussions
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

        Adapter::secure_query('UPDATE users SET hide_online = :hideonline, hide_inroom = :hideinroom, block_newfriends = :blocknewfriends WHERE id = :userid', [':hideonline' => (int)!$data['onlineStatusVisible'], ':hideinroom' => (int)!$data['friendCanFollow'], ':blocknewfriends' => (int)!$data['friendRequestEnabled'], ':userid' => Data::$user_instance->user_id]);

        Data::user_create_instance(Data::$user_instance->user_name);
    }
}
