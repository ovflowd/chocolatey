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
use Azure\Models\Json\ProfileSelfies as JsonSelfies;
use Azure\Models\Json\UserChannelsContent as JsonChannelsContent;
use Azure\Types\Controller as ControllerType;
use Azure\View\Misc;

/**
 * Class UserStories
 * @package Azure\Controllers
 */
class UserStories extends ControllerType
{
    /**
     * function construct
     * create a controller for user-stories
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
        $count = 0;
        $photos = [];
        $user_id = Misc::escape_text($_GET['user']);

        foreach (Adapter::secure_query("SELECT * FROM cms_stories_photos WHERE type = 'SELFIE' AND user_id = :uid  ORDER BY id DESC", [':uid' => $user_id]) as $row_a)
            $photos[$count++] = new JsonSelfies($row_a['id'], $row_a['user_id'], $row_a['image_preview_url'], $row_a['type'], $row_a['image_url'], $row_a['user_name'], $row_a['date'], $row_a['tags']);

        foreach (Adapter::secure_query("SELECT * FROM cms_stories_channels_inventory WHERE user_id = :uid ORDER BY id DESC", [':uid' => $user_id]) as $row_a):
            $row_b = Adapter::fetch_array(Adapter::secure_query("SELECT * FROM cms_stories_channels WHERE id = :cid", [':cid' => $row_a['channel_id']]));
            $photos[$count++] = new JsonChannelsContent($row_a['id'], $row_a['image_url'], $row_a['user_id'], $row_a['user_name'], $row_a['date'], $row_a['type'], $row_a['tags'], $row_a['title'], $row_b['url'], $row_b['title']);
        endforeach;

        header('Content-type: application/json');
        return str_replace("\\/", "/", json_encode($photos));
    }
}
