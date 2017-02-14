<?php

require_once __DIR__ . '/../vendor/autoload.php';

# Load ENV Environment
(new Dotenv\Dotenv(__DIR__ . '/../'))->load();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

# Create Lumen Application
$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

# Enable Laravel Facades (DB::)
$app->withFacades();

# Enable Laravel Eloquent Models
$app->withEloquent();

# Configure Mail Provider
$app->configure('mail');

# Configure Auth Provider
$app->configure('auth');

# Configure Chocolatey Provider
$app->configure('chocolatey');


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

# Add Auth Middleware
$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'cors' => App\Http\Middleware\Cors::class,
    'maintenance' => App\Http\Middleware\Maintenance::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
*/

$app->register(App\Providers\AppServiceProvider::class);

$app->register(App\Providers\SessionServiceProvider::class);

$app->register(App\Providers\ViewServiceProvider::class);

$app->register(App\Providers\AuthServiceProvider::class);

$app->register(\Sofa\Eloquence\ServiceProvider::class);

$app->register(Rdehnhardt\MaintenanceMode\Providers\MaintenanceModeServiceProvider::class);

$app->register(Intervention\Image\ImageServiceProviderLumen::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
*/

# Enable Lumen Controllers & Routes
$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__ . '/../routes/web.php';
});

return $app;
