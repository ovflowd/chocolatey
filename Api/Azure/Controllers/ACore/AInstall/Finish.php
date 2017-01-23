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

use Azure\Types\Controller as ControllerType;

/**
 * Class Finish
 * @package Azure\Controllers\ACore\AInstall
 */
class Finish extends ControllerType
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
            $path_to_file = ROOT_PATH . '/api/Init.php';
            $file_contents = file_get_contents($path_to_file);
            $file_contents = str_replace('define("INSTALLED", false);', 'define("INSTALLED", true);', $file_contents);
            file_put_contents($path_to_file, $file_contents);
            return;
        endif;
        header("Location: /");
        return;
    }
}