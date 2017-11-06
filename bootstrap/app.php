<?php

try {
    require_once __DIR__.'/../vendor/autoload.php';
} catch (Dotenv\Exception\InvalidPathException $e) {
    die('Failed to load Composer Dependencies. You doesn\'t have installed the Composer Dependencies.');
}

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    die('Failed to load Lumen Core. You doesn\'t have installed the Composer Dependencies.');
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

// Enable Laravel Facades (DB::)
$app->withFacades();

// Add Alias for File Systems
class_alias('Illuminate\Support\Facades\Storage', 'Storage');

// Enable Laravel Eloquent Models
$app->withEloquent();

// Configure File System
$app->configure('filesystems');

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

$app->routeMiddleware([
    'auth'        => App\Http\Middleware\Authenticate::class,
    'cors'        => App\Http\Middleware\Cors::class,
    'maintenance' => App\Http\Middleware\Maintenance::class,
]);

/*
|--------------------------------------------------------------------------
| Register Proxy Routes
|--------------------------------------------------------------------------
*/

if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
*/

$app->register(Illuminate\Filesystem\FilesystemServiceProvider::class);

$app->register(App\Providers\AppServiceProvider::class);

$app->register(App\Providers\SessionServiceProvider::class);

$app->register(App\Providers\UserServiceProvider::class);

$app->register(App\Providers\ViewServiceProvider::class);

$app->register(App\Providers\AuthServiceProvider::class);

$app->register(Sofa\Eloquence\BaseServiceProvider::class);

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

$app->router->group(['namespace' => 'App\Http\Controllers'], function ($router) {
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
