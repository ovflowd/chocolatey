<?php

/*
|--------------------------------------------------------------------------
| Habbo WEB Leaderboards
|--------------------------------------------------------------------------
|
| Here are the Rooms Routes
|
*/

// Render a specific Language Ecosystem
$app->get('habbo-web-leaderboards/{countryId}/visited-rooms/{range}/{data}', 'RoomsController@getLeader');
