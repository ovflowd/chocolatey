<?php

namespace App\Providers;

use App\Helpers\Session;
use Illuminate\Support\ServiceProvider;

/**
 * Class SessionServiceProvider.
 */
class SessionServiceProvider extends ServiceProvider
{
    /**
     * Register the Session Service Provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('chocosession', function () {
            return Session::getInstance();
        });

        Session::getInstance()->start();
    }
}
