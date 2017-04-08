<?php

/*
|--------------------------------------------------------------------------
| Habbo WEB ADS
|--------------------------------------------------------------------------
|
| Here comes the Advertisement Routes
|
*/

// Get Interstitial Client ADS
$app->get('habbo-web-ads/{interstitial}', 'ClientController@getInterstitial');
