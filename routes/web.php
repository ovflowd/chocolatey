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

# Main API Request is Forbidden
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

# Main ShopAPI Request is Forbidden
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

# Main HabboNEWS Request is Forbidden
$app->get('/habbo-web-news/', function () {
    return response('Unauthorized.', 401);
});

# Request a set of Articles, generally a category or front page
$app->get('/habbo-web-news/{country}/production/{view}', 'ArticleController@many');

# Request a single Article generally when you access directly an Article
$app->get('/habbo-web-news/{country}/production/articles/{article}', 'ArticleController@one');
