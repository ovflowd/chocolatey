<?php

/*
|--------------------------------------------------------------------------
| Miscellaneous
|--------------------------------------------------------------------------
|
| Other Routes used by Habbo
|
*/

// Get Habbo RSS
$app->get('rss.xml', 'ArticleController@getRss');

// Get Special AvatarImage for BigHead providing Username or Figure
$app->get('habbo-imaging/avatarimage', 'ImagingController@getUserHead');

// Get Special AvatarImage for Body Look only providing Figure
$app->get('habbo-imaging/avatar/{figure}', 'ImagingController@getUserBody');

// Get Group Badge
$app->get('habbo-imaging/badge/{badgeCode}', 'ImagingController@getGroupBadge');

// Get Youtube Thumbnail
$app->get('youtube', 'ImagingController@getYoutubeThumbnail');

// Espreso Integration Request
$app->get('espreso', function () {
    return response(view('errors.espreso'), 401);
});
