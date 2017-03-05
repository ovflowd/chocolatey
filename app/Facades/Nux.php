<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Nux
 * @package App\Facades
 */
class Nux extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'choconux';
    }
}

