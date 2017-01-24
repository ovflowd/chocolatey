<?php

/*
|--------------------------------------------------------------------------
| Habbo Main Route
|--------------------------------------------------------------------------
|
| Here it's registered the main Route
| This Route redirects to HabboWEB
|
*/

# Main Request Route
$app->get('/', function () {
    return view('habbo-web');
});

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
| Habbo Extradata Routes
|--------------------------------------------------------------------------
|
| Here we registered all Extradata Routes
| You can simply went to their respective controllers.
|
*/

# Main Extradata Request is Forbidden
$app->get('/extradata', function () {
    return response('Unauthorized.', 401);
});

# Show All Registered HabboWEB Photos
$app->get('/extradata/public/photos', 'PublicPhotos@show');

# Public Stories
$app->get('/extradata/public/users/stories', function () {
    return response()->json('aaa');
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

# Main HabboPAGES Request is Forbidden
$app->get('/habbo-web-pages/', function () {
    return response('Unauthorized.', 401);
});

# Request a Specific View of HabboWEB Pages
$app->get('/habbo-web-pages/production/{category}/{view}', 'PageController@show');

/*
|--------------------------------------------------------------------------
| Habbo WebNEWS Routes
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
