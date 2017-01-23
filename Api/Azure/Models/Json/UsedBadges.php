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
 * Class UsedBadges
 * @package Azure\Models\Json
 */
class UsedBadges extends JsonType
{

    /**
     * @var int
     */
    /**
     * @var int|string
     */
    /**
     * @var int|string
     */
    /**
     * @var int|string
     */
    public $badgeIndex = 0, $code, $name, $description;

    /**
     * function construct
     * create a model for the badge instance
     * @param integer $index
     * @param string $code
     * @param string $name
     * @param string $description
     */
    function __construct($index = 1, $code = 'FAN', $name = 'FAN', $description = 'default badge')
    {
        $this->badgeIndex = $index;
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
    }
}