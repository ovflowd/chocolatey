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

namespace Azure\Types;

use Azure\Interfaces\Json as JsonInterface;
use Azure\View\Misc;

/**
 * Class Json
 * @package Azure\Models\Json
 */
abstract class Json implements JsonInterface
{
    /**
     * function __get
     * return a selected variable
     * @param $name
     * @return mixed
     */
    function __get($name)
    {
        return $this->$name;
    }

    /**
     * function __set
     * store a value for a variable
     * @param $name
     * @param string $value
     * @return mixed|void
     */
    function __set($name, $value = '')
    {
        $this->$name = Misc::escape_text($value);
    }

    /**
     * function get_json
     * create a json encode
     * @param int $type
     * @return string
     */
    function get_json($type = 0)
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }

    /**
     * function __destruct
     * TODO: make the destruct destroy something
     * these void does nothing..
     */
    function __destruct()
    {

    }
}
