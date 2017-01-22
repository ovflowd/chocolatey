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

namespace Azure\Controllers;

use Azure\Database\Adapter;
use Azure\Models\Json\Photos as JsonPhotos;
use Azure\Types\Controller as ControllerType;
use Azure\View\Misc;

/**
 * Class UserPhotos
 * @package Azure\Controllers
 */
class UserPhotos extends ControllerType
{
	/**
	 * function construct
	 * create a controller for promos
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
		$count   = 0;
		$photos  = [];
		$user_id = Misc::escape_text($_GET['user']);

		foreach (Adapter::secure_query("SELECT * FROM cms_stories_photos WHERE type = 'PHOTO' AND user_id = :uid ORDER BY id DESC", [':uid' => $user_id]) as $row_a)
			$photos[$count++] = new JsonPhotos($row_a['id'], $row_a['user_id'], $row_a['image_preview_url'], $row_a['type'], $row_a['image_url'], $row_a['user_name'], $row_a['room_id'], $row_a['date'], $row_a['tags']);

		header('Content-type: application/json');
		return str_replace("\\/", "/", json_encode($photos));
	}
}
