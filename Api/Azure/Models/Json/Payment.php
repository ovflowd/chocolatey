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

use Azure\Models\Json\Purchase as JsonPurchase;
use Azure\Types\Json as JsonType;

/**
 * Class Payment
 * @package Azure\Models\Json
 */
class Payment extends JsonType
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
	 * @var bool|int|string
	 */
	/**
	 * @var bool|int|string
	 */
	/**
	 * @var bool|int|string
	 */
	/**
	 * @var Purchase|bool|int|string
	 */
	/**
	 * @var Purchase|bool|int|string
	 */
	/**
	 * @var Purchase|bool|int|null|string
	 */
	public $buttonLogoUrl, $buttonText, $category, $disclaimerRequired, $id, $name, $purchaseParams, $requestPath, $smallPrint;

	/**
	 * function construct
	 * create a model for the payment instance
	 * @param int $user_id
	 * @param string $name
	 * @param string $button
	 * @param int $image
	 * @param $category
	 */

	function __construct($user_id = 0, $name = '', $button = '', $image = 0, $category = '')
	{
		$this->name               = $name;
		$this->id                 = $user_id;
		$this->buttonText         = $button;
		$this->buttonLogoUrl      = $image;
		$this->category           = $category;
		$this->disclaimerRequired = false;
		$this->purchaseParams     = new JsonPurchase($user_id);
		$this->requestPath        = "online";
		$this->smallPrint         = null;
	}
}