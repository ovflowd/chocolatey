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

namespace Azure\Controllers\ADefault\ANewuser\AName;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\View\Data;
use Azure\View\Misc;
use stdClass;

/**
 * Class Check
 * @package Azure\Controllers\ADefault\ANewUser\AName
 */
class Check extends ControllerType
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

        if (!isset($_SESSION['is_newbie']))
            return null;

        $code = 'NAME_IN_USE';

        $data = json_decode(file_get_contents("php://input"), true);

        $validation_object = new stdClass();
        $validation_object->code = $code;
        $validation_object->validationResult = null;
        $validation_object->suggestions = [];

        if (isset($data['name'])):
            $name = Misc::escape_text($data['name']);

            if (((strlen($name) >= 3) && (strlen($name) <= 30)) && (preg_match('`[a-z]`', $name)) && (substr_count($name, ' ') == 0) && (stripos($name, 'MOD_') === false)):
                if ((Adapter::row_count(Adapter::secure_query("SELECT username FROM users WHERE username = :username LIMIT 1", [':username' => $name])) == 0) || ($name == Data::$user_instance->user_name)):
                    $validation_object->code = 'OK';
                endif;
            else:
                $validation_object->validationResult = new stdClass();
                $validation_object->validationResult->resultType = 'VALIDATION_ERROR_ILLEGAL_WORDS';
                $validation_object->validationResult->additionalInfo = 'MOD_';
                $validation_object->validationResult->valid = false;
            endif;
        endif;

        return json_encode($validation_object);
    }
}
