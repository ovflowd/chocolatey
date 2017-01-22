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

namespace Azure\Controllers\ADefault\APublic\AForgotPassword;

use Azure\Types\Controller as ControllerType;
use Azure\View\Mailer;
use stdClass;

/**
 * Class Send
 * @package Azure\Controllers\ADefault\APublic\AForgotPassword
 */
class Send extends ControllerType
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
        $data = json_decode(file_get_contents("php://input"), true);
        Mailer::send_reset_password($data['email']);

        $forgot_object = new stdClass();
        $forgot_object->email = $data['email'];

        return json_encode($forgot_object);
    }
}
