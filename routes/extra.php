<?php

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
$app->get('extradata', function () {
    return response('Unauthorized.', 401);
});

// Show All Registered HabboWEB Photos
$app->get('extradata/public/photos', 'PhotosController@show');

// Get User Stories
$app->get('extradata/public/users/{userId}/stories', 'ProfileController@getStories');

// Get User Stories
$app->get('extradata/public/users/{userId}/photos', 'ProfileController@getPhotos');

// Public Stories
$app->get('extradata/public/users/stories', function () {
    return response()->json('');
});

// Middleware that Requires Authentication
$app->group(['middleware' => 'auth'], function () use ($app) {

    // Recent Photo Moderations
    // @TODO: Synchronize with Photo Moderations
    $app->get('extradata/private/moderations/recentModerations', function () {
        return response()->json([]);
    });

    // Report a Specific Photo
    $app->post('extradata/private/creation/{photo}/report', 'PhotosController@report');

    // Like a Specific Photo
    $app->post('extradata/private/like/{photo}', 'PhotosController@likePhoto');

    // Like a Specific Photo
    $app->post('extradata/private/unlike/{photo}', 'PhotosController@unlikePhoto');

    // Delete a Specific Photo
    $app->delete('extradata/private/photo/{photo}', 'PhotosController@delete');
});
