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

namespace Azure;

use Azure\Mappers\User as Mapper;

/**
 * Class User
 * @package Azure
 */
final class User extends Mapper
{
	/**
	 * function __construct
	 * Construct the User Mapper
	 */
	final function __construct()
	{
		parent::__construct();
	}
}
