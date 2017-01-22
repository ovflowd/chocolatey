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
 * Class Subscription
 * @package Azure\Models\Json
 */
class Subscription extends JsonType
{

	/**
	 * @var bool
	 */
	/**
	 * @var bool|int
	 */
	/**
	 * @var bool|int|string
	 */
	/**
	 * @var bool|int|null|string
	 */
	/**
	 * @var bool|int|null|string
	 */
	/**
	 * @var bool|int|null|string
	 */
	/**
	 * @var bool|int|null|string
	 */
	/**
	 * @var bool|int|null|string
	 */
	/**
	 * @var bool|int|null|string
	 */
	/**
	 * @var bool|int|null|string
	 */
	/**
	 * @var bool|int|null|string
	 */
	/**
	 * @var bool|int|null|string
	 */
	public $active, $creditAmount, $description, $endTime, $iconId, $id, $locale, $name, $nextBillingTime, $price, $subscriptionType, $paymentMethods;

	/**
	 * function construct
	 * create a model for the subscription instance
	 * @param integer $user_id
	 * @param string $name
	 * @param string $description
	 * @param int $credits_amount
	 * @param int $price
	 * @param $type
	 * @param $icon_id
	 * @param $payment
	 */
	function __construct($user_id = 0, $name = '', $description = '', $credits_amount = 0, $price = 0, $type = 0, $icon_id = 0, $payment = '')
	{
		$this->name             = $name;
		$this->active           = false;
		$this->creditAmount     = $credits_amount;
		$this->endTime          = null;
		$this->iconId           = $icon_id;
		$this->id               = $user_id;
		$this->locale           = "en_US";
		$this->nextBillingTime  = null;
		$this->price            = $price;
		$this->subscriptionType = $type;
		$this->description      = $description;
		$this->paymentMethods   = $payment;
	}
}