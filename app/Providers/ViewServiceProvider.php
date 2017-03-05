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
        View::share('chocolatey', Config::get('chocolatey'));

        View::share('user', Session::get(Config::get('chocolatey.security.session')) ?? 'null');

        View::share('mail', Config::get('mail'));
    }
}
