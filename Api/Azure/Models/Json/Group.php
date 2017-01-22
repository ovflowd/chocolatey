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
 * Class Group
 * @package Azure\Models\Json
 */
class Group extends JsonType
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
	/**
	 * @var string
	 */
	/**
	 * @var string
	 */
	/**
	 * @var string
	 */
	/**
	 * @var string
	 */
	/**
	 * @var string
	 */
	/**
	 * @var string
	 */
	public $id, $name, $description, $type, $badgeCode, $roomId, $primaryColour, $secondaryColour, $isAdmin;

	/**
	 * function construct
	 * create a model for the group instance
	 * @param string $user_id
	 * @param string $name
	 * @param string $description
	 * @param string $type
	 * @param string $badge_code
	 * @param string $room_id
	 * @param string $primary_color
	 * @param string $secondary_color
	 * @param string $is_admin
	 */

	function __construct($user_id = '', $name = '', $description = '', $type = '', $badge_code = '', $room_id = '', $primary_color = '', $secondary_color = '', $is_admin = '')
	{
		$this->id              = $user_id;
		$this->name            = $name;
		$this->description     = $description;
		$this->type            = $type;
		$this->badgeCode       = $badge_code;
		$this->primaryColour   = $primary_color;
		$this->secondaryColour = $secondary_color;
		$this->isAdmin         = $is_admin;
	}
}