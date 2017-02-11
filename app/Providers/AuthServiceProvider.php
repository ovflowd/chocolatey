<?php

namespace App\Providers;

use App\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * Class AuthServiceProvider
 * @package App\Providers
 */
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
            $userData = Session::has('ChocolateyWEB') ? Session::get('ChocolateyWEB') : null;

            return $request->path() == 'api/public/authentication/login'
                ? Session::set('ChocolateyWEB', User::where('mail', $request->json()->get('email'))
                    ->where('password', hash(Config::get('chocolatey.security.hash'), $request->json()->get('password')))->first()) : $userData;
        });
    }
}
