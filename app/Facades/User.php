<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class User
 * @package App\Facades
 */
class User extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chocouser';
    }
}

