<?php

namespace App\Providers;

use App\Http\Controllers\LoginController;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            return $request->path() == 'api/public/authentication/login'
                ? (new LoginController)->login($request) : null;
        });
    }
}
