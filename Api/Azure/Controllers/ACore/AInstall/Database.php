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
 * Class Database
 * @package Azure\Controllers\ACore\AInstall
 */
class Database extends ControllerType
{
    /**
     * function show
     * render and return content
     */
    function show()
    {
        if (!INSTALLED):
            $database_settings = [
                'host' => Misc::escape_text($_POST['host_name']),
                'user' => Misc::escape_text($_POST['host_user']),
                'pass' => Misc::escape_text($_POST['host_pass']),
                'name' => Misc::escape_text($_POST['host_db']),
                'port' => Misc::escape_text($_POST['host_port']),
                'type' => 'mysql'
            ];

            Adapter::set_instance($database_settings);

            if (Adapter::row_count(Adapter::query("SELECT id FROM catalog_pages")) >= 1):
                if (strpos(file_get_contents(ROOT_PATH . "/Api/Gogo.php"), '$database_settings = array') == false):
                    file_put_contents(ROOT_PATH . "/Api/Gogo.php", "\n//database settings \n" . '$database_settings = ' . var_export($database_settings, true) . ';', FILE_APPEND);
                    header("Location: /settings");
                    return;
                endif;
            else:
                header("Location: /error?db");
                return;
            endif;
            header("Location: /error?db");
            return;
        endif;
        header("Location: /");
        return;
    }
}