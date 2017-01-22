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

/**
 * Class Client
 * @package Azure\Controllers\ADefault
 */
class Client extends ControllerType
{
    /**
     * @var mixed
     */
    private $hotel_settings;

    /**
     * function construct
     * create a controller for client url
     * @param string $hotel_settings
     */

    function __construct($hotel_settings = '')
    {
        $this->hotel_settings = unserialize(SYSTEM_SETTINGS);
    }

    /**
     * function return
     * return client link
     * @return string
     */
    function show()
    {
        header('Content-type: application/json');
        return (((isset($_SESSION['is_newbie'])) && ($_SESSION['is_newbie'] == true) && (((Data::$user_instance->is_newbie) == 2) || ((Data::$user_instance->is_newbie) == 1))) ? '{"clienturl":"' . $this->hotel_settings['global_url'] . $this->hotel_settings['client_newbie_name'] . '"}' : '{"clienturl":"' . $this->hotel_settings['global_url'] . $this->hotel_settings['client_name'] . '"}');
    }
}