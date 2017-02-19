<?php

namespace App\Providers;

use App\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
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
            return $request->path() == 'api/public/authentication/login'
                ? $this->auth($request) : $this->recover($request);
        });
    }

    /**
     * Does the Authentication
     *
     * @param Request $request
     * @return User|null
     */
    protected function auth(Request $request)
    {
        return Session::set(Config::get('chocolatey.security.session'), User::where('mail', $request->json()->get('email'))
            ->where('password', hash(Config::get('chocolatey.security.hash'),
                $request->json()->get('password')))->first());
    }

    /**
     * Recover User Data
     *
     * @param Request $request
     * @return User|null
     */
    protected function recover(Request $request)
    {
        return Session::get(Config::get('chocolatey.security.session')) ?? null;
    }
}
