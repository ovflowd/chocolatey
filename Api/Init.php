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

/**
 * This file is the Main Instance of Azure, Here The Configuration is Putted, and the Autoload System is Created. Also here is defined all Server Variables.
 */

error_reporting(1);

define("INSTALLED", false);

/*
 * * settings of the cms
 */

//database settings 
$database_settings = [];

//hotel settings 
$hotel_settings = [];

// define constants
defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
defined('IMAGER_RESOURCE') || define("IMAGER_RESOURCE", ROOT_PATH . "/Public/habbo-imaging/"); // if not going to install delete this line
defined('PATH_RESOURCE') || define("PATH_RESOURCE", IMAGER_RESOURCE . "BE/"); // if not going to install delete this line
defined('DATABASE_SETTINGS') || define('DATABASE_SETTINGS', serialize($database_settings));
defined('SYSTEM_SETTINGS') || define('SYSTEM_SETTINGS', serialize($hotel_settings));

// auto load namespaces
spl_autoload_register(function ($class) {
    include_once(str_replace('\\', '/', $class . '.php'));
});