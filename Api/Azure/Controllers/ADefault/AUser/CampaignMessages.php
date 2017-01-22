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

namespace Azure\Controllers\ADefault\AUser;

use Azure\Types\Controller as ControllerType;
use Azure\View\Data;

/**
 * Class CampaignMessages
 * @package Azure\Controllers\ADefault\AUser
 */
class CampaignMessages extends ControllerType
{
    /**
     * function construct
     * create a controller for campaigns
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
        return Data::compose_campaigns(true);
    }
}
