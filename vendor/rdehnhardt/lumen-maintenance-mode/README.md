# Lumen maintenance mode

[![Latest Stable Version](https://poser.pugx.org/rdehnhardt/lumen-maintenance-mode/v/stable)](https://packagist.org/packages/rdehnhardt/lumen-maintenance-mode)
[![Total Downloads](https://poser.pugx.org/rdehnhardt/lumen-maintenance-mode/downloads)](https://packagist.org/packages/rdehnhardt/lumen-maintenance-mode)
[![License](https://poser.pugx.org/rdehnhardt/lumen-maintenance-mode/license)](https://packagist.org/packages/rdehnhardt/lumen-maintenance-mode)
[![Build Status](https://travis-ci.org/rdehnhardt/lumen-maintenance-mode.svg)](https://travis-ci.org/rdehnhardt/lumen-maintenance-mode)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rdehnhardt/lumen-maintenance-mode/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rdehnhardt/lumen-maintenance-mode/?branch=master)

## How to install

```
composer require rdehnhardt/lumen-maintenance-mode
```

## How to configure
In bootstrap/app.php, add this instruction in providers

```
$app->register(
    Rdehnhardt\MaintenanceMode\Providers\MaintenanceModeServiceProvider::class
);
```

## Set View

```
resources/views/errors/503.blade.php
```

## Put the application into maintenance mode.

```
php artisan down
```

## Bring the application out of maintenance mode.

```
php artisan up
```

## IP released for access

In .env file

```
ALLOWED_IPS=999.99.9.999,999.99.9.999,999.99.9.999
```
