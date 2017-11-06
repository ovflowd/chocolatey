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
$router->group(['middleware' => 'maintenance'], function () use ($router) {

    // Main ShopAPI Request is Forbidden
    $router->get('shopapi', function () {
        return response('Unauthorized.', 401);
    });

    // Get a List of all Shop Countries
    $router->get('shopapi/public/countries', 'ShopController@listCountries');

    // Get the Inventory of a specific Country
    $router->get('shopapi/public/inventory/{countryCode}', 'ShopController@getInventory');

    // Middleware that Requires Authentication
    $router->group(['middleware' => 'auth'], function () use ($router) {
        // Get User Purse
        $router->get('shopapi/purse', 'ShopController@getPurse');

        // Get Offers Page
        $router->get('shopapi/offerwall/url', 'ShopController@getWall');

        // Get User Purchase History
        $router->get('shopapi/history', 'ShopController@getHistory');

        // Get a List of all Shop Countries
        $router->get('shopapi/countries', 'ShopController@listCountries');

        // Get the Inventory of a specific Country
        $router->get('shopapi/inventory/{countryCode}', 'ShopController@getInventory');

        // Redirect to Purchase Proceed
        $router->get('shopapi/proceed/{paymentCategory}/{countryCode}/{shopItem}/{paymentMethod}', 'ShopController@proceed');

        // Redeem a Voucher
        $router->post('shopapi/voucher/redeem', 'ShopController@redeem');

        // Redirect to Success Purchase
        $router->post('shopapi/success/{paymentCategory}/{countryCode}/{shopItem}/{paymentMethod}', 'ShopController@success');
    });
});
