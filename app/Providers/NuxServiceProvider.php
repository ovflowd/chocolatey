<?php

namespace App\Providers;

use App\Helpers\Nux;
use Illuminate\Support\ServiceProvider;

/**
 * Class NuxServiceProvider.
 */
class NuxServiceProvider extends ServiceProvider
{
    /**
     * Register the Session Service Provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('choconux', function () {
            return Nux::getInstance();
        });
    }
}
