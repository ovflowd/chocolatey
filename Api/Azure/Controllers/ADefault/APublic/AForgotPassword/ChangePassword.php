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

namespace Azure\Controllers\ADefault\APublic\AForgotPassword;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\User;

/**
 * Class ChangePassword
 * @package Azure\Controllers\ADefault\APublic\AForgotPassword
 */
class ChangePassword extends ControllerType
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

        if (Adapter::row_count(Adapter::secure_query('SELECT * FROM cms_restore_password WHERE user_hash = :userhash LIMIT 1', [':userhash' => $data['token']])) == 1):
            $get = Adapter::fetch_object(Adapter::secure_query('SELECT * FROM cms_restore_password WHERE user_hash = :userhash LIMIT 1', [':userhash' => $data['token']]));
            $row = Adapter::fetch_object(Adapter::secure_query('SELECT * FROM users WHERE id = :userid LIMIT 1', [':userid' => $get->user_id]));
            $data['currentPassword'] = '';
            User::change_password($data, $row->id, false);
            Adapter::secure_query('DELETE FROM cms_restore_password WHERE user_hash = :userhash', [':userhash' => $data['token']]);
            return null;
        endif;

        header('HTTP/1.1 404 Not Found');
        return null;
    }
}
