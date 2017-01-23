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

namespace Azure\Interfaces;

/**
 * Interface Json
 * @package Azure\Interfaces
 */
interface Json
{
    /**
     * @param $name
     * @return mixed
     */
    function __get($name);

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    function __set($name, $value);

    /**
     * @param $type
     * @return mixed
     */
    function get_json($type);

    /**
     * destruct xit
     */
    function __destruct();
}