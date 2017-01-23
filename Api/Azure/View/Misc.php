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

namespace Azure\View;

/**
 * Class Misc
 * This Class has miscellaneous voids
 * @package Azure\View
 */
final class Misc
{
    /**
     * function redirect
     * redirect to the hell , sorry to the url,
     * @param string $url
     */
    static function redirect($url = '')
    {
        $base = explode("/", $_SERVER['SCRIPT_NAME']);

        for ($i = 0; $i < count($base); $i++)
            unset($base[sizeof($base) - 1]);

        $base = implode("/", $base);
        header("Location: " . $base . $url);
    }

    /**
     * function link_to
     * create a link to...
     * @param string $url
     * @param bool $header
     * @return string
     */
    static function link_to($url = '', $header = false)
    {
        $base = explode('/', $_SERVER['SCRIPT_NAME']);

        for ($i = 0; $i < count($base); $i++)
            unset($base[sizeof($base) - 1]);

        $base = implode('/', $base);
        return ($header) ? 'https://' . $_SERVER['HTTP_HOST'] . $base . $url : $base . $url;
    }

    /**
     * function escape_text
     * previne idiots (lammers) to do lammer things
     * @param string $text_string
     * @return array|mixed|string
     */
    static function escape_text($text_string = '')
    {
        if (is_array($text_string))
            return array_map(__METHOD__, $text_string);
        if (!empty($text_string) && is_string($text_string))
            return str_replace(['\\', "\0", "\n", "\r", "'", '"', "\x1a"], ['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'], $text_string);
        return $text_string;
    }
}

