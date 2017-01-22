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
use Azure\View\Misc;

/**
 * Class Preferences
 * @package Azure\Models\Json
 */
class Preferences extends JsonType
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
	public $profileVisible, $onlineStatusVisible, $friendCanFollow, $friendRequestEnabled, $offlineMessagingEnabled = true, $emailNewsletterEnabled = true, $emailMiniMailNotificationEnabled = true, $emailFriendRequestNotificationEnabled = true, $emailGiftNotificationEnabled = true, $emailRoomMessageNotificationEnabled = true, $emailGroupNotificationEnabled = true;

	/**
	 * function construct
	 * create a model for the badge instance
	 * @param bool $profile_visible
	 * @param bool $online_visible
	 * @param bool $friend_can_follow
	 * @param bool $friend_can_add
	 */
	function __construct($profile_visible = true, $online_visible = true, $friend_can_follow = true, $friend_can_add = true)
	{
		$this->profileVisible       = !(bool)$profile_visible;
		$this->onlineStatusVisible  = !(bool)$online_visible;
		$this->friendCanFollow      = !(bool)$friend_can_follow;
		$this->friendRequestEnabled = !(bool)$friend_can_add;
	}

	/**
	 * function __set
	 * store a value for a variable
	 * @param $name
	 * @param string $value
	 * @return mixed|void
	 */
	function __set($name, $value = '')
	{
		$this->$name = Misc::escape_text((($value == '1') ? false : true));
	}
}