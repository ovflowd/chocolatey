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

/**
 * Class UserStories
 * @package Azure\Controllers
 */
class PhotosFurni extends ControllerType
{
	/**
	 * function construct
	 * create a controller for photos-furnis
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
		$photo_id = $_GET['photo_id'];

		$row_a = Adapter::fetch_array(Adapter::secure_query("SELECT * FROM cms_stories_photos WHERE id = :uid LIMIT 1", [':uid' => $photo_id]));
		$photo = new JsonPhotos($row_a['id'], $row_a['user_id'], $row_a['image_preview_url'], $row_a['type'], $row_a['image_url'], $row_a['user_name'], $row_a['room_id'], $row_a['date'], $row_a['tags']);

		header('Content-type: application/json');
		return str_replace("\\/", "/", json_encode($photo));
	}
}
