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

namespace Azure\Mappers;

use Azure\Models\System as Model;
use Azure\View\Data;

/**
 * Class System
 * @package Azure\Mappers
 */
class System extends Model
{
    /**
     * function get_system_class
     * return the variables of the system instance
     * @return array
     */
    static function get_system_class()
    {
        if (Data::check_if_system_exists()):
            $hotelSettings = [];

            foreach (get_class_vars(get_class(Data::$system_instance)) as $name => $value)
                $hotelSettings[$name] = Data::$system_instance->{$name};

            return $hotelSettings;
        endif;
        return null;
    }
}