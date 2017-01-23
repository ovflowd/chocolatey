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

namespace Azure\Controllers\ACore\AInstall;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\View\Misc;

/**
 * Class Administration
 * @package Azure\Controllers\ACore\AInstall
 */
class Administration extends ControllerType
{

    /**
     * function construct
     * create a controller for shop purse
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
        if (!INSTALLED):
            Adapter::secure_query("INSERT INTO cms_hk_users (username,password,rank) VALUES (MD5(:user),MD5(:pass),6);", [':user' => Misc::escape_text($_POST['admin_user']), ':pass' => Misc::escape_text($_POST['admin_pass'])]);
            header("Location: /finish");
            return;
        endif;
        header("Location: /");
        return;
    }
}