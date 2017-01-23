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

namespace Azure\Controllers\AHobbaNet\AAse;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;

class Validate extends ControllerType
{
    /**
     * function construct
     * create a controller for promos
     */

    function __construct()
    {

    }

    /**
     * function do_validate
     * check if user has permissions
     * @param int $rank
     * @return bool
     */
    static function do_validate($rank = 0)
    {
        @session_start();
        if (isset($_SESSION['hobbanet'])):
            $arr = unserialize($_SESSION['hobbanet']);
            if (Adapter::row_count(Adapter::secure_query("SELECT * FROM cms_hk_users WHERE username = MD5(:username) AND hash = :hash", [':username' => $arr['username'], ':hash' => $arr['hash']])) == 1):
                $hash = md5((rand(10, 30 . '-ase-' . rand(40, 60) . '-ase-' . rand(80, 90))));
                Adapter::secure_query("UPDATE cms_hk_users SET hash = :hash WHERE username = MD5(:username)", [':hash' => $hash, ':username' => $arr['username']]);
                $arr = [
                    'username' => $arr['username'],
                    'hash' => $hash,
                    'rank' => $arr['rank']
                ];
                $_SESSION['hobbanet'] = serialize($arr);
                if ($arr['rank'] >= $rank)
                    return true;
                else
                    return false;
            else:
                header("Location: /theallseeingeye/web/login");
                return false;
            endif;
        else:
            session_destroy();
            header("Location: /");
            return false;
        endif;
    }

    /**
     * function show
     * render and return content
     */
    function show()
    {
        return;
    }
}
