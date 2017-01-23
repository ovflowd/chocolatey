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

namespace Azure\Controllers\ADefault\APublic\ARegistration;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\View\Data;
use stdClass;

/**
 * Class Activate
 * @package Azure\Controllers\ADefault\APublic\ARegistration
 */
class Activate extends ControllerType
{
    /**
     * function construct
     * create a controller for channels
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
        $query = Adapter::secure_query('SELECT * FROM cms_users_verification WHERE user_hash = :userhash', [':userhash' => $data['token']]);
        if (Adapter::row_count($query) == 1):
            $fetch = Adapter::fetch_object($query);

            Adapter::secure_query('UPDATE cms_users_verification SET verified = :verified WHERE user_hash = :userhash', [':verified' => 'true', ':userhash' => $data['token']]);
            Data::user_create_instance($fetch->user_id);

            $row = Adapter::fetch_object(Adapter::secure_query('SELECT mail FROM users WHERE id = :userid', [':userid' => $fetch->user_id]));

            $activate_object = new stdClass();
            $activate_object->email = $row->mail;
            $activate_object->emailVerified = true;
            $activate_object->identityVerified = true;

            return json_encode($activate_object);
        endif;

        header('HTTP/1.1 404 Not Found');

        $error_object = new stdClass();
        $error_object->error = 'activation.invalid_token';

        return json_encode($error_object);
    }
}
