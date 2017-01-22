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

namespace Azure\Controllers\ADefault;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\View\Imagers\AvatarImager;
use Azure\View\Misc;

/**
 * Class AvatarImage
 * @package Azure\Controllers\ADefault
 */
class AvatarImage extends ControllerType
{
    var $input_figure = '', $input_action = '', $input_direction = '', $input_head_direction = '', $input_gesture = '', $input_size = '', $input_format = '', $input_frame = '', $input_head_only = '', $image = '';

    /**
     * function construct
     * create a controller for notifications
     */

    function __construct()
    {
        $this->input_figure = strtolower($_GET["figure"]);
        $this->input_action = isset($_GET["action"]) ? strtolower($_GET["action"]) : 'std';
        $this->input_direction = isset($_GET["direction"]) ? $_GET["direction"] : 4;
        $this->input_head_direction = isset($_GET["head_direction"]) ? $_GET["head_direction"] : $this->input_direction;
        $this->input_gesture = isset($_GET["gesture"]) ? strtolower($_GET["gesture"]) : 'std';
        $this->input_size = isset($_GET["size"]) ? strtolower($_GET["size"]) : 'n';
        $this->input_format = isset($_GET["img_format"]) ? strtolower($_GET["img_format"]) : 'png';
        $this->input_frame = isset($_GET["frame"]) ? strtolower($_GET["frame"]) : '0';
        $this->input_head_only = isset($_GET["headonly"]) ? $_GET["headonly"] : false;

        if (isset($_GET['user'])):
            $figure = Adapter::fetch_array(Adapter::secure_query("SELECT look FROM users WHERE username = :username ", ['username' => Misc::escape_text($_GET['user'])]));
            $this->input_figure = $figure['look'];
        endif;

        $this->input_action = explode(",", $this->input_action);
        $this->input_format = $this->input_format == "gif" ? "gif" : "png";
        $this->input_frame = explode(",", $this->input_frame);
    }

    /**
     * function show
     * render and return content
     * @return string
     */
    function show()
    {

        $avatar_image = new AvatarImager($this->input_figure, $this->input_direction, $this->input_head_direction, $this->input_action, $this->input_gesture, $this->input_frame, $this->input_head_only, $this->input_size);
        $this->image = $avatar_image->generate($this->input_format);

        if ($this->image !== false):
            header('Process-Time: ' . $avatar_image->process_time);
            header('Error-Message: ' . $avatar_image->error);
            header('Debug-Message: ' . $avatar_image->debug);
            header('Generator-Version: ' . $avatar_image->version);
            header('Content-Type: image/' . $this->input_format);
            echo $this->image;
        endif;
    }
}