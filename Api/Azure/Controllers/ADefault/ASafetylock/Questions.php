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
use Azure\View\Data;

/**
 * Class Questions
 * @package Azure\Controllers\ADefault\ASafetyLock
 */
class Questions extends ControllerType
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
        $query = Adapter::fetch_object(Adapter::secure_query('SELECT trade_lock FROM users WHERE id = :userid', [':userid' => Data::$user_instance->user_id]));

        if ($query->trade_lock == '0')
            return '[]';

        header('Content-type: application/json');
        return '[{"questionId":1,"questionKey":"IDENTITY_SAFETYQUESTION_1"},{"questionId":2,"questionKey":"IDENTITY_SAFETYQUESTION_2"}]';
    }
}
