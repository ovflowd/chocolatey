<?php

/*
|--------------------------------------------------------------------------
| Habbo API Routes
|--------------------------------------------------------------------------
|
| Here are registered all main HabboWEB api routes
| You can simply went to their respective controllers.
|
*/

$app->get('/api', function () {
    return response('Unauthorized.', 401);
});

/*
|--------------------------------------------------------------------------
| Habbo ShopAPI Routes
|--------------------------------------------------------------------------
|
| Here are registered all shop pages related routes
| You can simply went to their respective controllers.
|
*/

$app->get('/shopapi', function () {
    return response('Unauthorized.', 401);
});

/*
|--------------------------------------------------------------------------
| Habbo WebPages Routes
|--------------------------------------------------------------------------
|
| Here are registered all HabboWEB Pages Routes
| Those Routes are special, like News, Advertisement, and others.
|
*/

$app->get('/habbo-web-news/', function () {
    return response('Unauthorized.', 401);
});

$app->get('/habbo-web-news/{country}/', function () {
    return response('Unauthorized.', 401);
});

$app->get('/habbo-web-news/{country}/production/{view}', 'ArticleController@many');

$app->get('/habbo-web-news/{country}/production/articles/{article}', 'ArticleController@one');
