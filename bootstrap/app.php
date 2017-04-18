<?php

require_once __DIR__.'/../vendor/autoload.php';

// Load ENV Environment
(new Dotenv\Dotenv(__DIR__.'/../'))->load();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

// Create Lumen Application
$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

// Enable Laravel Facades (DB::)
$app->withFacades();

// Enable Laravel Eloquent Models
$app->withEloquent();

// Configure Mail Provider
$app->configure('mail');

// Configure Auth Provider
$app->configure('auth');

// Configure Chocolatey Provider
$app->configure('chocolatey');

// Configure Maintenance Provider
$app->configure('maintenance');

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
*/

// Add Auth Middleware
$app->routeMiddleware([
    'auth'        => App\Http\Middleware\Authenticate::class,
    'cors'        => App\Http\Middleware\Cors::class,
    'maintenance' => App\Http\Middleware\Maintenance::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
*/

$app->register(App\Providers\AppServiceProvider::class);

$app->register(App\Providers\SessionServiceProvider::class);

$app->register(App\Providers\UserServiceProvider::class);

$app->register(App\Providers\ViewServiceProvider::class);

$app->register(App\Providers\AuthServiceProvider::class);

$app->register(\Sofa\Eloquence\ServiceProvider::class);

$app->register(Rdehnhardt\MaintenanceMode\Providers\MaintenanceModeServiceProvider::class);

$app->register(Intervention\Image\ImageServiceProviderLumen::class);

$app->register(App\Providers\NuxServiceProvider::class);

$app->register(App\Providers\MailServiceProvider::class);

$app->register(App\Providers\ValidationServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
*/

// Enable Lumen Controllers & Routes
$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__.'/../routes/main.php';
    require __DIR__.'/../routes/api.php';
    require __DIR__.'/../routes/extra.php';
    require __DIR__.'/../routes/web.php';
    require __DIR__.'/../routes/lang.php';
    require __DIR__.'/../routes/lead.php';
    require __DIR__.'/../routes/shop.php';
    require __DIR__.'/../routes/ads.php';
    require __DIR__.'/../routes/news.php';
    require __DIR__.'/../routes/misc.php';
    require __DIR__.'/../routes/pages.php';
});

return $app;
