<?php

use Illuminate\Support\Facades\Config;

/*
|--------------------------------------------------------------------------
| Habbo Extradata Routes
|--------------------------------------------------------------------------
|
| Here we registered all Extradata Routes
| You can simply went to their respective controllers.
|
*/

// Main Extradata Request is Forbidden
$router->get('extradata', function () {
    return response('Unauthorized.', 401);
});

// Show All Registered HabboWEB Photos
$router->get('extradata/public/photos', 'PhotosController@show');

// Get User Stories
$router->get('extradata/public/users/{userId}/stories', 'ProfileController@getStories');

// Get User Stories
$router->get('extradata/public/users/{userId}/photos', 'ProfileController@getPhotos');

// Public Stories
$router->get('extradata/public/users/stories', function () {
    return response()->json('');
});

// Cross domain for Client
$router->get('crossdomain.xml', function () {
    $domains = '';

    foreach (Config::get('chocolatey.cors') as $domain) {
        $domains .= "<allow-access-from domain='{$domain}'/>".PHP_EOL;
    }

    return response('<?xml version="1.0"?>'.PHP_EOL
        .'<!DOCTYPE cross-domain-policy SYSTEM "http://www.macromedia.com/xml/dtds/cross-domain-policy.dtd">'.PHP_EOL
        .'<cross-domain-policy>'.PHP_EOL.$domains.'</cross-domain-policy>')->header('Content-Type', 'text/xml');
});

// Middleware that Requires Authentication
$router->group(['middleware' => 'auth'], function () use ($router) {

    // Recent Photo Moderations
    // @TODO: Synchronize with Photo Moderations
    $router->get('extradata/private/moderations/recentModerations', function () {
        return response()->json([]);
    });

    // Report a Specific Photo
    $router->post('extradata/private/creation/{photo}/report', 'PhotosController@report');

    // Like a Specific Photo
    $router->post('extradata/private/like/{photo}', 'PhotosController@likePhoto');

    // Like a Specific Photo
    $router->post('extradata/private/unlike/{photo}', 'PhotosController@unlikePhoto');

    // Delete a Specific Photo
    $router->delete('extradata/private/photo/{photo}', 'PhotosController@delete');
});
