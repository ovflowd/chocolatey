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

namespace Azure\Controllers\ADefault\ASafetylock;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\User;
use Azure\View\Data;
use stdClass;

/**
 * Class Enabled
 * @package Azure\Controllers\ADefault\APublic
 */
class Save extends ControllerType
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
        $data = json_decode(file_get_contents("php://input"), true);
        $data['currentPassword'] = $data['password'];

        header('Content-type: application/json');
        if (User::change_password($data, Data::$user_instance->user_id, true, false) == true):
            $query = Adapter::fetch_object(Adapter::secure_query('SELECT trade_lock FROM users WHERE id = :userid', [':userid' => Data::$user_instance->user_id]));

            if ($query->trade_lock == 0)
                Adapter::secure_query('UPDATE users SET trade_lock = :statusl WHERE id = :userid', [':statusl' => '1', ':userid' => Data::$user_instance->user_id]);

            if (Adapter::row_count(Adapter::secure_query('SELECT * FROM cms_security_questions WHERE user_id = :userid', [':userid' => Data::$user_instance->user_id])) == 0)
                Adapter::secure_query('INSERT INTO cms_security_questions (user_id,question_one,question_two) VALUES (:userid,:questionone,:questiontwo)', [':questionone' => $data['answer1'], ':questiontwo' => $data['answer2'], ':userid' => Data::$user_instance->user_id]);

            Adapter::secure_query('UPDATE cms_security_questions SET question_one = :questionone, question_two = :questiontwo WHERE user_id = :userid', [':questionone' => $data['answer1'], ':questiontwo' => $data['answer2'], ':userid' => Data::$user_instance->user_id]);
            return null;
        endif;

        header('HTTP/1.1 400 Bad Request');

        $error_object = new stdClass();
        $error_object->error = 'invalid_password';

        return json_encode($error_object);
    }
}
