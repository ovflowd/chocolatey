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
use Azure\Models\Json\Rooms as JsonRooms;
use Azure\Types\Controller as ControllerType;

/**
 * Class Rooms
 * @package Azure\Controllers\ADefault\APublic
 */
class Rooms extends ControllerType
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
		header("Access-Control-Allow-Origin: eabbu.com,eabbu.top");
		
		$roomId = end(explode('/', $_SERVER['REQUEST_URI']));

		Adapter::query("SET NAMES utf8");
        $row_a = Adapter::fetch_array(Adapter::secure_query("SELECT * FROM rooms WHERE id = :roomid", [':roomid' => $roomId]));
        $row_b = Adapter::fetch_object(Adapter::secure_query("SELECT * FROM users WHERE id = :ownerid", [':ownerid' => $row_a['owner']]));
		$row_c = Adapter::row_count(Adapter::secure_query("SELECT * FROM navigator_publics WHERE room_id = :roomid", [':roomid' => $row_a['id']]));
		$tags  = explode(',', $row_a['tags']);
		$photos = new JsonRooms($row_a['id'], $row_a['caption'], $row_a['description'], $row_a['users_max'], $row_b->username, $row_b->id, $row_a['score'], $tags, $row_c == 1);		

        header('Content-type: application/json');
        return str_replace("\\/", "/", json_encode($photos));
    }
}
