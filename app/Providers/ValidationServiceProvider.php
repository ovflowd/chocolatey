<?php

namespace App\Providers;

use App\Helpers\Validation;
use Illuminate\Support\ServiceProvider;

/**
 * Class ValidationServiceProvider
 * @package App\Providers
 */
class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register the Session Service Provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('chocovalidate', function () {
            return Validation::getInstance();
        });
    }
}
