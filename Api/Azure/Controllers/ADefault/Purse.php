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

namespace Azure\Controllers\ADefault;

use Azure\Types\Controller as ControllerType;
use Azure\View\Data;
use stdClass;

/**
 * Class Purse
 * @package Azure\Controllers\ADefault
 */
class Purse extends ControllerType
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
        $purse_object = new stdClass();
        $purse_object->creditBalance = Data::$user_instance->user_credits;
        $purse_object->diamondBalance = Data::$user_instance->user_pixels;
        $purse_object->habboClubDays = 0;
        $purse_object->buildersClubDays = 0;
        $purse_object->buildersClubFurniLimit = Data::$user_instance->user_builders_items;

        header('Content-type: application/json');
        return json_encode($purse_object);
    }
}