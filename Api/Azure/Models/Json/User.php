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
 * Class User
 * @package Azure\Models\Json
 */
class User extends JsonType
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
	/**
	 * @var int|mixed|string
	 */
	/**
	 * @var int|mixed|string
	 */
	/**
	 * @var bool|int|mixed|string
	 */
	/**
	 * @var bool|int|mixed|string
	 */
	/**
	 * @var bool|int|mixed|string
	 */
	/**
	 * @var bool|int|mixed|string
	 */
	/**
	 * @var bool|int|mixed|string
	 */
	/**
	 * @var bool|int|mixed|string
	 */
	/**
	 * @var bool|int|mixed|string
	 */
	public $uniqueId, $name, $email, $figureString, $selectedBadges, $memberSince, $profileVisible, $sessionLogId, $identityId, $emailVerified, $trusted, $accountId, $traits;

	/**
	 * function construct
	 * create a model for the user instance
	 * @param int $user_user_id
	 * @param string $user_name
	 * @param string $user_email
	 * @param string $user_gender
	 * @param string $user_motto
	 * @param string $user_look
	 * @param array $selected_badges selected_badges
	 * @param string $memberSince
	 * @param $verified_email
	 */

	function __construct($user_user_id = 0, $user_name = '', $user_email = '', $user_gender = 'M', $user_motto = 'default motto', $user_look = '', $selected_badges = [], $memberSince = '2015-03-13T18:45:02.000+0000', $verified_email = true)
	{
		$this->uniqueId       = $user_user_id;
		$this->name           = $user_name;
		$this->email          = $user_email;
		$this->motto          = $user_name;
		$this->figureString   = $user_look;
		$this->selectedBadges = $selected_badges;
		$this->memberSince    = $memberSince;
		$this->profileVisible = true;
		$this->sessionLogId   = $user_user_id;
		$this->loginLogId     = $user_user_id;
		$this->identityId     = $user_user_id;
		$this->emailVerified  = $verified_email;
		$this->trusted        = true;
		$this->accountId      = $user_user_id;
		$this->traits         = 'USER';
	}
}