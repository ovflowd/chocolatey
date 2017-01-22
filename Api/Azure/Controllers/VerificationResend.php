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

use Azure\Types\Controller as ControllerType;
use Azure\View\Data;
use Azure\View\Mailer;

/**
 * Class VerificationResend
 * @package Azure\Controllers\ADefault\ASettings\AEMail
 */
class VerificationResend extends ControllerType
{
    /**
     * function construct
     * create a controller for change password
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
        header('Content-type: application/json; charset=utf-8');
        Mailer::send_nux_mail(Data::$user_instance->user_email);
    }
}
