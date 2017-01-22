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
use Azure\Models\Json\Channels as JsonChannels;
use Azure\Types\Controller as ControllerType;

/**
 * Class Channels
 * @package Azure\Controllers\ADefault\APublic
 */
class Channels extends ControllerType
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
        $count = 0;
        $channels = [];

        foreach (Adapter::query("SELECT * FROM cms_stories_channels") as $row_a)
            $channels[$count++] = new JsonChannels($row_a['id'], $row_a['title'], $row_a['description'], $row_a['tag'], $row_a['title_key'], $row_a['image'], $row_a['url']);

        header('Content-type: application/json');
        return json_encode($channels);
    }
}
