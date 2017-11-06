<?php

/*
|--------------------------------------------------------------------------
| Habbo Web Articles Routes
|--------------------------------------------------------------------------
|
| Here are registered all HabboWEB Pages Routes
| Those Routes are special, like News, Advertisement, and others.
|
*/

// Main HabboNEWS Request is Forbidden
$router->get('habbo-web-news/', function () {
    return response('Unauthorized.', 401);
});

// Request a set of Articles, generally a category or front page
$router->get('habbo-web-news/{country}/production/{view}', 'ArticleController@many');

// Request a single Article generally when you access directly an Article
$router->get('habbo-web-news/{country}/production/articles/{article}', 'ArticleController@one');
