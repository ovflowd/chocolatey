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
 * Class Friend
 * @package Azure\Models\Json
 */
class Friend extends JsonType
{

	/**
	 * @var string
	 */
	/**
	 * @var string
	 */
	/**
	 * @var int|string
	 */
	/**
	 * @var int|string
	 */
	public $name, $motto, $uniqueId, $figureString;

	/**
	 * function construct
	 * create a model for the friend instance
	 * @param string $username
	 * @param string $name
	 * @param int $description
	 * @param string $look
	 */

	function __construct($username = '', $name = '', $description = 0, $look = '')
	{
		$this->name         = $username;
		$this->motto        = $name;
		$this->uniqueId     = $description;
		$this->figureString = $look;
	}
}