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
class Badge extends JsonType
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
	public $code, $name, $description;

	/**
	 * function construct
	 * create a model for the badge instance
	 * @param string $code
	 * @param string $name
	 * @param string $description
	 */
	function __construct($code = 'FAN', $name = 'FAN', $description = 'default badge')
	{
		$this->code        = $code;
		$this->name        = $name;
		$this->description = $description;
	}
}