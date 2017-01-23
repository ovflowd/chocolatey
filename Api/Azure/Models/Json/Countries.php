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

namespace Azure\Models\Json;

use Azure\Types\Json as JsonType;

/**
 * Class Badge
 * @package Azure\Models\Json
 */
class Countries extends JsonType
{

    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    public $id, $name, $locale = null, $countryCode;

    /**
     * function construct
     * create a model for the countries instance
     * @param string $id
     * @param string $name
     * @param string $locale
     * @param string $country_code
     */
    function __construct($id = '', $name = '', $locale = '', $country_code = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->locale = $locale;
        $this->countryCode = $country_code;
    }
}