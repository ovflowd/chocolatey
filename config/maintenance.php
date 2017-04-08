<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enforce Hotel Maintenance
    |--------------------------------------------------------------------------
    |
    | Enable the Hotel Maintenance
    | <To enable Maintenance mode write 'php artisan down'>
    | <To disable Maintenance mode write 'php artisan up'>
    | *those commands need to be written on the console/terminal/cmd*
    |
    */

    // Using this isn't Recommended
    'enforce' => false,

    /*
    |--------------------------------------------------------------------------
    | Maintenance Title
    |--------------------------------------------------------------------------
    |
    | This Will be the Title on the Maintenance
    |
    */

    'title' => 'Stop! Maintenance',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Text
    |--------------------------------------------------------------------------
    |
    | You can set here the Maintenance text for yout Hotel.
    |
    */

    'text' => "We're really sorry but we're on Maintenance. You can check further updates by accessing our Twitter. We apologize a lot about this",
];
