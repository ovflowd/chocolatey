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

namespace Azure\Controllers\ADefault\APublic;

use Azure\Database\Adapter;
use Azure\Models\Json\Countries as JsonCountries;
use Azure\Types\Controller as ControllerType;

/**
 * Class Countries
 * @package Azure\Controllers\ADefault\APublic
 */
class Countries extends ControllerType
{
    /**
     * function construct
     * create a controller for countries
     */

    function __construct()
    {

    }

    /**
     * function show
     * render and return content
     * @return string
     */
    function show()
    {

        $count = 0;
        $countries = [];

        foreach (Adapter::query("SELECT * FROM cms_shop_countries") as $row_a)
            $countries[$count++] = new JsonCountries($row_a['country_id'], $row_a['country_name'], $row_a['country_locale'], $row_a['country_code']);

        header('Content-type: application/json');
        return json_encode($countries);
    }
}
