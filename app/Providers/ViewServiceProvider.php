<?php

namespace App\Providers;

use App\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class ViewServiceProvider
 * @package App\Providers
 */
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Configures all Global Blade Variables
     *
     * @return void
     */
    public function register()
    {
        View::share('chocolatey', json_decode(json_encode(Config::get('chocolatey'))));

        View::share('user', ($session = Session::get(Config::get('chocolatey.security.session'))) == null ? 'null' : $session);

        View::share('mail', json_decode(json_encode(Config::get('mail'))));

        View::share('maintenance', json_decode(json_encode(Config::get('maintenance'))));
    }
}
