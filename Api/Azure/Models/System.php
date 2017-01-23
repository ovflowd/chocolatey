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

namespace Azure\Models;

use Azure\Types\Model as ModelType;

/**
 * Class System
 * @package Azure\Models
 */
class System extends ModelType
{
    /**
     * @var string
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
     * @var int|string
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
     * @var int|string
     */
    /**
     * @var int|string
     */
    /**
     * @var int|string
     */
    public $server_lang = "en", $online_users = 0, $registered_users = 0, $rooms_loaded = 0, $stamp = 0, $server_ver = '1.0', $rooms_data = 0, $groups_data = 0, $items_data = 0, $stafflogs_data = 0, $bans_data = 0;

    /**
     * function construct
     * starts the system data
     * @param string $server_lang
     * @param int $online_user
     * @param string $server_ver
     * @param int $registered_users
     * @param int $rooms_loaded
     * @param int $stamp
     * @param int $rooms
     * @param int $groups
     * @param int $items
     * @param int $bans
     * @param int $logs
     */
    function __construct($server_lang = 'en', $online_user = 0, $server_ver = '1.0', $registered_users = 0, $rooms_loaded = 0, $stamp = 0, $rooms = 0, $groups = 0, $items = 0, $bans = 0, $logs = 0)
    {
        $this->server_lang = $server_lang;
        $this->online_users = $online_user;
        $this->registered_users = $registered_users;
        $this->server_ver = $server_ver;
        $this->rooms_loaded = $rooms_loaded;
        $this->stamp = $stamp;
        $this->rooms_data = $rooms;
        $this->groups_data = $groups;
        $this->items_data = $items;
        $this->bans_data = $bans;
        $this->stafflogs_data = $logs;
    }
}