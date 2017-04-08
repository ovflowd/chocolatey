<?php

namespace App\Providers;

use App\Helpers\Mail;
use Illuminate\Support\ServiceProvider;

/**
 * Class MailServiceProvider.
 */
class MailServiceProvider extends ServiceProvider
{
    /**
     * Register the Session Service Provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('chocomail', function () {
            return Mail::getInstance();
        });
    }
}
