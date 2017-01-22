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

namespace Azure\Controllers\ADefault\ANewuser\ARoom;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\View\Data;
use Azure\View\Misc;

/**
 * Class Select
 * @package Azure\Controllers\ADefault\ANewUser\ARoom
 */
class Select extends ControllerType
{
    /**
     * function construct
     * create a controller for inventory
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
        header('Content-type: application/json');
        header('HTTP/1.1 200 OK');

        if (!isset($_SESSION['is_newbie']))
            return;

        if ((Data::$user_instance->is_newbie) == 0)
            return;

        if ((Data::$user_instance->is_newbie) == 1)
            return;

        $data = json_decode(file_get_contents("php://input"), true);

        $room_index = Misc::escape_text($data['roomIndex']);
        $user_id = Data::$user_instance->user_id;
        $username = Data::$user_instance->user_name;

        if ($room_index == 1):
            $floor = '610';
            $wallpaper = '2403';
            $landscape = '0.0';
        elseif ($room_index == 2):
            $floor = '307';
            $wallpaper = '3104';
            $landscape = '1.10';
        elseif ($room_index == 3):
            $floor = '409';
            $wallpaper = '1902';
            $landscape = '0.0';
        endif;

        if ((Data::$user_instance->is_newbie) == 2):

            Adapter::secure_query("INSERT INTO rooms_data
                                    (roomtype, caption, owner, description, category, state, users_max, model_name, wallpaper, floor, landscape) VALUES
                                    ('private', :caption, :username, :owner, '2', 'open', '25', 'model_h', :wallpaper, :floor, :landscape)"
                , [':caption' => "Central $username", ':username' => $username, ':owner' => "Quarto de $username", ':wallpaper' => $wallpaper, ':floor' => $floor, ':landscape' => $landscape]);

            $instance = Adapter::get_instance();
            $room_id = $instance->lastInsertId();

            Adapter::secure_query("UPDATE users SET home_room = :room WHERE id = :user", [':room' => $room_id, ':user' => $user_id]);

            if ($room_index == 3):
                Adapter::query("INSERT INTO items_rooms VALUES
								(null, '$user_id', '$room_id', '3397', '3', '8', '7', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2946', '', '10', '2', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2666', '3', '6', '7', '1.300', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2681', '3', '9', '7', '1.300', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3397', '3', '7', '7', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2675', '0', '5', '10', '0.000', '6', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3397', '3', '6', '7', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3397', '3', '9', '7', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2673', '1', '6', '9', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3867', '', '7', '2', '1.000', '4', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2673', '1', '8', '10', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2677', '1', '4', '10', '0.000', '2', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2673', '1', '8', '9', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2673', '1', '6', '10', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2675', '0', '5', '9', '0.000', '6', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2672', '1', '4', '11', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2677', '1', '4', '9', '0.000', '2', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3901', '', '9', '3', '1.000', '6', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3901', '', '6', '3', '1.000', '2', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '14066', '2', '0', '0', '0.000', '0', ':w=4,8 l=0,27 r', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '14386', '0', '0', '0', '0.000', '0', ':w=4,7 l=5,29 l', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '14071', '0', '0', '0', '0.000', '0', ':w=2,10 l=4,43 l', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '14072', '1', '0', '0', '0.000', '0', ':w=8,1 l=14,27 r', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '14383', '1', '0', '0', '0.000', '0', ':w=6,1 l=5,31 r', '0', '', '0', '0');");
            elseif ($room_index == 2):
                Adapter::query("INSERT INTO items_rooms VALUES
								(null, '$user_id', '$room_id', '2957', '2', '3', '10', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '9', '5', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2853', '', '3', '9', '0.000', '2', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3889', '1', '8', '2', '1.470', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3898', '1', '9', '8', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2487', '', '5', '11', '1.300', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3880', '0', '8', '8', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '4182', '2', '3', '9', '0.800', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2781', '', '4', '9', '0.000', '4', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2952', '0', '3', '10', '0.400', '2', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '7', '5', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3900', '0', '5', '4', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3302', '', '7', '3', '1.000', '2', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2502', '0', '3', '10', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2952', '0', '3', '12', '0.000', '2', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3870', '0', '9', '9', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2955', '', '3', '11', '0.000', '2', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '8', '5', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '10', '4', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3880', '1', '10', '8', '0.000', '4', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3806', '', '5', '11', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2957', '2', '3', '9', '0.400', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3870', '0', '8', '11', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3880', '1', '8', '9', '0.000', '6', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3900', '0', '5', '2', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '10', '5', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '7', '4', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3870', '0', '9', '11', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2955', '', '4', '9', '0.000', '4', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '7', '2', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3312', '0', '8', '3', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '9', '2', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2957', '0', '3', '9', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '10', '2', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3870', '0', '8', '9', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '10', '3', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2781', '', '3', '11', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2781', '', '3', '9', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3315', '0', '8', '2', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8029', '', '0', '0', '0.000', '0', ':w=4,8 l=7,31 r', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8262', '1', '0', '0', '0.000', '0', ':w=4,5 l=11,33 l', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8108', '1', '0', '0', '0.000', '0', ':w=7,1 l=9,31 r', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8108', '1', '0', '0', '0.000', '0', ':w=10,1 l=0,26 r', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8262', '1', '0', '0', '0.000', '0', ':w=4,3 l=5,37 l', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8096', '0', '0', '0', '0.000', '0', ':w=2,11 l=5,58 l', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8029', '', '0', '0', '0.000', '0', ':w=4,8 l=8,31 l', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8096', '0', '0', '0', '0.000', '0', ':w=2,10 l=10,56 l', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8108', '3', '0', '0', '0.000', '0', ':w=5,1 l=15,34 r', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8108', '3', '0', '0', '0.000', '0', ':w=9,1 l=0,26 r', '0', '', '0', '0');");
            elseif ($room_index == 1):
                Adapter::query("INSERT INTO items_rooms VALUES
								(null, '$user_id', '$room_id', '3893', '1', '8', '4', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '18', '', '10', '9', '0.000', '4', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '4636', '', '3', '10', '0.010', '2', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2169', '', '9', '5', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2188', '', '7', '5', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '4654', '', '3', '9', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '18', '', '10', '12', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '4654', '', '5', '9', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3712', '', '9', '10', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3642', '1', '7', '2', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '18', '', '9', '12', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3632', '4', '9', '2', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '18', '', '9', '9', '0.000', '4', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '4654', '', '5', '11', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '2228', '', '8', '5', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '3632', '4', '6', '2', '1.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '4654', '', '3', '11', '0.000', '0', '', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8364', '', '0', '0', '0.000', '0', ':w=2,10 l=1,34 l', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8021', '0', '0', '0', '0.000', '0', ':w=4,3 l=12,34 l', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8294', '0', '0', '0', '0.000', '0', ':w=2,10 l=2,34 l', '0', '', '0', '0'),
								(null, '$user_id', '$room_id', '8199', '1', '0', '0', '0.000', '0', ':w=4,8 l=0,45 r', '0', '', '0', '0');");
            endif;
        endif;

        Adapter::secure_query("UPDATE users SET novato = '0' WHERE username = :username OR id = :userid", [':username' => $username, ':userid' => $user_id]);
        Data::user_create_instance($user_id);
        $_SESSION['is_newbie'] = false;
        return null;
    }
}
