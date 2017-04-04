<?php

namespace App\Providers;

use App\Helpers\User;
use Illuminate\Support\ServiceProvider;

/**
 * Class UserServiceProvider
 * @package App\Providers
 */
class UserServiceProvider extends ServiceProvider
{
    /**
     * Register the Session Service Provider
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('chocouser', function () {
            return User::getInstance();
        });
    }
}
