<?php

/*
|--------------------------------------------------------------------------
| Habbo WebPages Routes
|--------------------------------------------------------------------------
|
| Here are registered all HabboWEB Pages Routes
| Those Routes are special, like News, Advertisement, and others.
|
*/

// Main HabboPAGES Request is Forbidden
$router->get('habbo-web-pages/', function () {
    return response('Unauthorized.', 401);
});

// Request a Specific View of HabboWEB Pages
$router->get('habbo-web-pages/production/{category}/{view}', 'PageController@show');
