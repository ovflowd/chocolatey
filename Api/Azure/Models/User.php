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
 * Class User
 * @package Azure\Models
 */
class User extends ModelType
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
     * @var bool|int|string
     */
    /**
     * @var bool|int|string
     */
    /**
     * @var array|bool|int|string
     */
    /**
     * @var array|bool|int|string
     */
    /**
     * @var array|bool|int|string
     */
    /**
     * @var array|bool|int|string
     */
    /**
     * @var array|bool|int|string
     */
    /**
     * @var array|bool|int|string
     */
    public $user_id, $user_name, $user_email, $user_gender, $user_motto, $user_credits, $user_pixels, $user_address, $client_ticket, $user_look, $user_is_admin, $user_builders_items, $user_badges, $user_friends, $user_rooms, $user_used_badges, $user_groups, $user_json, $user_preferences, $verified_email, $is_newbie;

    /**
     * function construct
     * create a model for the user instance
     * @param int $user_id
     * @param string $user_name
     * @param string $user_email
     * @param string $user_gender
     * @param string $user_motto
     * @param int $user_credits
     * @param int $user_pixels
     * @param string $user_address
     * @param string $client_ticket
     * @param string $user_look
     * @param bool $user_is_admin
     * @param int $user_builders_items
     * @param array $user_badges
     * @param array $user_friends
     * @param array $user_rooms
     * @param array $user_used_badges
     * @param array $user_groups
     * @param array $user_json
     * @param array $preferences_json
     * @param bool $email_verified
     */
    function __construct($user_id = 0, $user_name = '', $user_email = '', $user_gender = 'M', $user_motto = 'default motto', $user_credits = 0, $user_pixels = 0, $user_address = '', $client_ticket = '', $user_look = '', $user_is_admin = false, $user_builders_items = 300, $user_badges = [], $user_friends = [], $user_rooms = [], $user_used_badges = [], $user_groups = [], $user_json = [], $preferences_json = [], $email_verified = true, $is_newbie = 0)
    {
        $this->user_id = (int)$user_id;
        $this->verified_email = (string)$email_verified;
        $this->user_name = (string)$user_name;
        $this->user_email = (string)$user_email;
        $this->user_gender = (string)$user_gender;
        $this->user_motto = (string)$user_motto;
        $this->user_credits = (int)$user_credits;
        $this->user_pixels = (int)$user_pixels;
        $this->user_address = (string)$user_address;
        $this->client_ticket = (string)$client_ticket;
        $this->user_look = (string)$user_look;
        $this->user_is_admin = (bool)$user_is_admin;
        $this->user_builders_items = (int)$user_builders_items;
        $this->user_badges = $user_badges;
        $this->user_friends = $user_friends;
        $this->user_rooms = $user_rooms;
        $this->user_used_badges = $user_used_badges;
        $this->user_groups = $user_groups;
        $this->user_preferences = $preferences_json;
        $this->user_json = $user_json;
        $this->is_newbie = $is_newbie;
    }

    /**
     * function client_ticket
     * generate random client ticket
     * @return string
     */
    static function client_ticket()
    {
        $data = '';
        for ($i = 1; $i <= 10; $i++)
            $data .= rand(0, 8);
        $data .= "d";
        $data .= rand(0, 4);
        $data .= "c";
        $data .= rand(0, 6);
        $data .= "c";
        $data .= rand(0, 8);
        $data .= "c";
        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 4);
        $data .= "d";
        for ($i = 1; $i <= 3; $i++)
            $data .= rand(0, 6);
        $data .= "ae";
        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 6);
        $data .= "bcb";
        $data .= rand(0, 4);
        $data .= "a";
        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 8);
        $data .= "c";
        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 4);
        $data .= "a";
        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 8);
        return $data;
    }

    /**
     * function user_hash
     * generate a user hash
     * @return int|string
     */
    static function user_hash()
    {
        $data = rand(0, 9);
        for ($i = 1; $i <= 9; $i++)
            $data .= rand(0, 9);
        $data .= "d";
        $data .= rand(0, 7);
        $data .= "c";
        $data .= rand(0, 5);
        $data .= "c";
        $data .= rand(0, 3);
        $data .= "c";
        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 5);
        $data .= "d";
        for ($i = 1; $i <= 3; $i++)
            $data .= rand(0, 7);
        $data .= "ae";
        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 7);
        $data .= "bcb";
        $data .= rand(0, 5);
        $data .= "a";
        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 9);
        $data .= "c";
        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 3);
        $data .= "a";
        for ($i = 1; $i <= 2; $i++)
            $data .= rand(0, 9);
        return $data;
    }

    /**
     * function window_name
     * generate a window name for the user
     * @return int|string
     */
    static function window_name()
    {
        $data = rand(0, 9);
        for ($i = 1; $i <= 29; $i++)
            $data .= rand(0, 9);
        return $data;
    }
}
