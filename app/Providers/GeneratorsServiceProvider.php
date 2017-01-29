<?php

namespace App\Providers;

use App\Helpers\Session;
use Illuminate\Support\ServiceProvider;

/**
 * Class GeneratorsServiceProvider
 * @package App\Providers
 */
class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Register the Generators Service Provider
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('azuregenerators', function () {
            return Session::getInstance();
        });
    }
}
