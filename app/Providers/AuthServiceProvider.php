<?php

namespace App\Providers;

use App\Facades\Session;
use App\Http\Controllers\LoginController;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Boot the authentication services for the application.
     * If an User is stored in the Session recover it
     * Only will recover if the Path() isn't the Authentcation Path
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            $userData = !empty(Session::get('azureWEB')) ? Session::get('azureWEB') : null;

            return $request->path() == 'api/public/authentication/login'
                ? (new LoginController)->login($request) : $userData;
        });
    }
}
