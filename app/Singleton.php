<?php

namespace App;

/**
 * Class Singleton.
 */
abstract class Singleton
{
    /**
     * Create and return a User instance.
     *
     * @return $this
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new static();
        }

        return $instance;
    }
}
