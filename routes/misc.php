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
$router->get('rss.xml', 'ArticleController@getRss');

// Get Special AvatarImage for BigHead providing Username or Figure
$router->get('habbo-imaging/avatarimage', 'ImagingController@getUserHead');

// Get Special AvatarImage for Body Look only providing Figure
$router->get('habbo-imaging/avatar/{figure}', 'ImagingController@getUserBody');

// Get Group Badge
$router->get('habbo-imaging/badge/{badgeCode}', 'ImagingController@getGroupBadge');

// Get Youtube Thumbnail
$router->get('youtube', 'ImagingController@getYoutubeThumbnail');

// Espreso Integration Request
$router->get('espreso', function () {
    return response(view('errors.espreso'), 401);
});
