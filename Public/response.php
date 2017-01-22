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

// include load file
include_once('../Vendor/autoload.php');

// include load file
include_once('../Api/Init.php');

use Azure\Framework;
use Azure\Response;
use Azure\View;
use Azure\View\Data;

// start session
session_start();

// start system
(Data::framework_instance(false, new Framework(true)));

// check all system existence
(Data::check_if_user_exists());
(Data::check_if_system_exists());

(new Response());






