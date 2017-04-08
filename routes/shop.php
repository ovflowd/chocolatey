<?php

/*
|--------------------------------------------------------------------------
| Habbo ShopAPI Routes
|--------------------------------------------------------------------------
|
| Here are registered all shop pages related routes
| You can simply went to their respective controllers.
|
*/

// Maintenance Middleware
$app->group(['middleware' => 'maintenance'], function () use ($app) {

    // Main ShopAPI Request is Forbidden
    $app->get('shopapi', function () {
        return response('Unauthorized.', 401);
    });

    // Get a List of all Shop Countries
    $app->get('shopapi/public/countries', 'ShopController@listCountries');

    // Get the Inventory of a specific Country
    $app->get('shopapi/public/inventory/{countryCode}', 'ShopController@getInventory');

    // Middleware that Requires Authentication
    $app->group(['middleware' => 'auth'], function () use ($app) {
        // Get User Purse
        $app->get('shopapi/purse', 'ShopController@getPurse');

        // Get Offers Page
        $app->get('shopapi/offerwall/url', 'ShopController@getWall');

        // Get User Purchase History
        $app->get('shopapi/history', 'ShopController@getHistory');

        // Get a List of all Shop Countries
        $app->get('shopapi/countries', 'ShopController@listCountries');

        // Get the Inventory of a specific Country
        $app->get('shopapi/inventory/{countryCode}', 'ShopController@getInventory');

        // Redirect to Purchase Proceed
        $app->get('shopapi/proceed/{paymentCategory}/{countryCode}/{shopItem}/{paymentMethod}', 'ShopController@proceed');

        // Redeem a Voucher
        $app->post('shopapi/voucher/redeem', 'ShopController@redeem');

        // Redirect to Success Purchase
        $app->post('shopapi/success/{paymentCategory}/{countryCode}/{shopItem}/{paymentMethod}', 'ShopController@success');
    });
});
