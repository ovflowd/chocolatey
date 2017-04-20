<?php

namespace App\Helpers;

use App\Singleton;
use Illuminate\Support\Facades\Config;

/**
 * Class Validation.
 */
final class Validation extends Singleton
{
    /**
     * Filter an Username from the Invalid Names Base.
     *
     * @param string $username
     *
     * @return bool
     */
    public function filterUserName(string $username): bool
    {
        return $this->checkSize($username, 4, 15) && $this->checkWords($username) &&
            preg_match('/^[a-zA-Z0-9_\-=?!@:.$]+$/', $username);
    }

    /**
     * Check String Size.
     *
     * @param string $needle
     * @param int    $min
     * @param int    $max
     *
     * @return bool
     */
    public function checkSize(string $needle, int $min, int $max)
    {
        return strlen($needle) <= $max && strlen($needle) >= $min;
    }

    /**
     * Check for Illegal Words.
     *
     * @param string $needle
     *
     * @return bool
     */
    public function checkWords(string $needle): bool
    {
        return count(array_filter(Config::get('chocolatey.invalid'), function ($illegal) use ($needle) {
            return stripos($needle, $illegal) !== false;
        })) == 0;
    }
}
