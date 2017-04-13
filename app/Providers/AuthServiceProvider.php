<?php

namespace App\Providers;

use App\Helpers\User;
use Illuminate\Support\ServiceProvider;

/**
 * Class AuthServiceProvider.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Boot the authentication services for the application.
     * If an User is stored in the Session recover it
     * Only will recover if the Path() isn't the Authentcation Path.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            return User::getInstance()->getUser();
        });
    }
}
