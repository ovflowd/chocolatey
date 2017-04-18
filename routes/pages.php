<?php

/*
|--------------------------------------------------------------------------
| Habbo Client Pages Routes
|--------------------------------------------------------------------------
|
| Here are registered all Habbo Pages Routes
| Those Routes are special, like News, Advertisement, and others.
|
*/

// Main HabboPAGES Request is Forbidden
$app->get('habbo-pages/', function () {
    return response('Unauthorized.', 401);
});

// Request a HabboPage
$app->get('habbo-pages/{page}', 'PageController@habboPage');

// Request a Categorized HabboPage
$app->get('habbo-pages/{category}/{page}', 'PageController@habboPage');
