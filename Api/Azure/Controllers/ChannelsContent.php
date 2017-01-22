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
use Azure\Models\Json\ChannelsContent as JsonChannelsContent;
use Azure\Models\Json\ChannelsWithContent as JsonChannels;
use Azure\Types\Controller as ControllerType;
use Azure\View\Misc;

/**
 * Class ChannelsContent
 * @package Azure\Controllers
 */
class ChannelsContent extends ControllerType
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

		$count           = 0;
		$channels_photos = [];
		$channel         = Misc::escape_text($_GET['channel']);
		$channel_id      = Adapter::fetch_array(Adapter::secure_query("SELECT * FROM cms_stories_channels WHERE url = :url", [':url' => $channel]));

		foreach (Adapter::secure_query("SELECT * FROM cms_stories_channels_inventory WHERE channel_id = :id", [':id' => $channel_id['id']]) as $row_a)
			$channels_photos[$count++] = new JsonChannelsContent($row_a['id'], $row_a['image_url'], $row_a['user_id'], $row_a['user_name'], $row_a['date'], $row_a['type'], $row_a['tags'], $row_a['title']);

		header('Content-type: application/json');
		$channels = new JsonChannels($channel_id['id'], $channel_id['title'], $channel_id['description'], $channel_id['tag'], $channel_id['title_key'], $channel_id['image'], $channel_id['url'], $channels_photos);
		return json_encode($channels);
	}
}
