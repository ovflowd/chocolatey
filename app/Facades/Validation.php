<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Validation
 * @package App\Facades
 */
class Validation extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chocovalidate';
    }
}
