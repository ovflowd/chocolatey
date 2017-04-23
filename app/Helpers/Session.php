<?php

namespace App\Helpers;

use App\Singleton;

/**
 * Class Session.
 */
final class Session extends Singleton
{
    /**
     * Rename the Session ID.
     *
     * @param string $name
     */
    public function rename($name)
    {
        session_name($name);
    }

    /**
     * Start Session Handler.
     */
    public function start()
    {
        @session_start();
    }

    /**
     * Stop Session Handler.
     */
    public function destroy()
    {
        @session_destroy();
    }

    /**
     * Store a Variable in the Session.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;

        return $value;
    }

    /**
     * Get a Attribute Value from Session.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->has($key) ? $_SESSION[$key] : null;
    }

    /**
     * Check if a Key exists in the Session.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * Erase a Attribute from Session.
     *
     * @param string $key
     */
    public function erase($key)
    {
        $_SESSION[$key] = null;

        unset($_SESSION[$key]);
    }
}
