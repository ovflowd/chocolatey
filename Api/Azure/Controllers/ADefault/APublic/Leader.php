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

namespace Azure\Controllers\ADefault\APublic;

use Azure\Database\Adapter;
use Azure\Models\Json\Leader as JsonLeader;
use Azure\Types\Controller as ControllerType;

/**
 * Class Leader
 * @package Azure\Controllers\ADefault\APublic
 */
class Leader extends ControllerType
{
    /**
     * function construct
     * create a controller for channels
     */

    function __construct()
    {

    }

    /**
     * function show
     * render and return content
     */
    function show()
    {
        $hotelUrl = unserialize(SYSTEM_SETTINGS)->emu_ip;

        header("Access-Control-Allow-Origin: $hotelUrl");
        $count = 0;
        $photos = [];

        Adapter::query("SET NAMES utf8");
        foreach (Adapter::query("SELECT * FROM rooms") as $row_a):
            $row_b = Adapter::fetch_object(Adapter::secure_query("SELECT * FROM users WHERE id = :ownerid", [':ownerid' => $row_a['owner']]));
            $row_c = Adapter::row_count(Adapter::secure_query("SELECT * FROM navigator_publics WHERE room_id = :roomid", [':roomid' => $row_a['id']]));

            $tags = explode(',', $row_a['tags']);

            $photos[$count++] = new JsonLeader($row_a['id'], $row_a['score'], $count, $row_a['caption'], $row_a['description'], $row_b->username, $row_b->id, $row_a['score'], $tags, $row_c == 1);
        endforeach;

        header('Content-type: application/json');
        return str_replace("\\/", "/", json_encode($photos));
    }
}
