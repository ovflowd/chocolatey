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
 * Class Room
 * @package Azure\Models\Json
 */
class Room extends JsonType
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
	public $id, $name, $description, $ownerUniqueId;

	/**
	 * function construct
	 * create a model for the friend instance
	 * @param string $room_id
	 * @param string $name
	 * @param int|string $description
	 * @param string $user_id
	 */

	function __construct($room_id = '', $name = '', $description = '', $user_id = '')
	{
		$this->id            = $room_id;
		$this->name          = $name;
		$this->description   = $description;
		$this->ownerUniqueId = $user_id;
	}
}