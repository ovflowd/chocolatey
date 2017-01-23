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
 * Class Purse
 * @package Azure\Models\Json
 */
class Purse extends JsonType
{

    /**
     * @var array
     */
    /**
     * @var array|string
     */
    /**
     * @var array|int|string
     */
    /**
     * @var array|int|string
     */
    /**
     * @var array|int|string
     */
    /**
     * @var array|int|string
     */
    /**
     * @var array|int|string
     */
    /**
     * @var array|int|string
     */
    /**
     * @var array|int|string
     */
    public $categories, $countryCode, $creditAmount, $description, $iconId, $id, $name, $price, $paymentMethods;

    /**
     * function construct
     * create a model for the subscription instance
     * @param integer $user_id
     * @param string $name
     * @param string $description
     * @param int $credits_amount
     * @param int $price
     * @param $categories
     * @param $country
     * @param $icon_id
     * @param $payment
     */

    function __construct($user_id = 0, $name = '', $description = '', $credits_amount = 0, $price = 0, $categories = [], $icon_id = 0, $country = '', $payment = '')
    {
        $this->name = $name;
        $this->creditAmount = $credits_amount;
        $this->iconId = $icon_id;
        $this->id = $user_id;
        $this->countryCode = $country;
        $this->price = $price;
        $this->categories = $categories;
        $this->description = $description;
        $this->paymentMethods = $payment;
    }
}