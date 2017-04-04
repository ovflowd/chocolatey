<?php

namespace App\Providers;

use App\Helpers\Mail;
use Illuminate\Support\ServiceProvider;

/**
 * Class MailServiceProvider
 * @package App\Providers
 */
class MailServiceProvider extends ServiceProvider
{
    /**
     * Register the Session Service Provider
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
