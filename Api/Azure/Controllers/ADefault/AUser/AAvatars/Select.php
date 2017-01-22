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

use Azure\Types\Controller as ControllerType;
use Azure\View\Data;

/**
 * Class Avatars
 * @package Azure\Controllers\ADefault\AUser
 */
class Select extends ControllerType
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
     * @return mixed|void
     */
    function show()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['name'])) Data::user_create_instance($data['name']);
    }
}
