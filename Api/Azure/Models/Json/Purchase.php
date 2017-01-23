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
 * Class Purchase
 * @package Azure\Models\Json
 */
class Purchase extends JsonType
{

    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $countryId = 5113, $paymentMethodId, $pricePointId = 9478;

    /**
     * function construct
     * create a model for the purchase instance
     * @param $user_id
     */

    function __construct($user_id = 0)
    {
        $this->paymentMethodId = $user_id;
    }
}