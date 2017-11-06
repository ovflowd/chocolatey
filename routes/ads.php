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
$router->get('habbo-web-ads/{interstitial}', 'ClientController@getInterstitial');
