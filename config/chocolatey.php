<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chocolatey Version
    |--------------------------------------------------------------------------
    |
    | Please don't change this value.
    |
    */

    'version' => 3.0,

    /*
    |--------------------------------------------------------------------------
    | Hotel Name
    |--------------------------------------------------------------------------
    |
    | This is the Hotel Name Setting
    | That will be used to visible show your Hotel
    |
    */

    'hotelName' => 'Habbo',
    'shortName' => 'Habbo',

    /*
    |--------------------------------------------------------------------------
    | Hotel URL
    |--------------------------------------------------------------------------
    |
    | This is the Hotel URL Setting
    | That will be used to visible show your Hotel
    |
    */

    'hotelUrl' => 'http://localhost',

    /*
    |--------------------------------------------------------------------------
    | Arcturus Account
    |--------------------------------------------------------------------------
    |
    | In Order to Use the Camera Successfully
    | You need provide your Arcturus Account
    | <If you don't have one yet, register at http://arcturus.wf>
    |
    | <Camera it's a donation perk feature.>
    | *Arcturus it's Open Source and Coded without any Refunds*
    | *Give today a Donation and makes that the project continues being published and updated*
    |
    |                                   - The General
    |
    */

    'arcturus' => 'your-username',

    /*
    |--------------------------------------------------------------------------
    | Recaptcha Key
    |--------------------------------------------------------------------------
    |
    | This is used for Registration
    | Without a valid Recaptcha Key you cannot Register on the Hotel
    | Get Your Recapthca Key HERE: <https://google.com/recaptcha>
    |
    */

    'recaptcha' => '6LdhyucSAAAAAKNhbY53azV2gZul4DcD8Xo111yp',

    /*
    |--------------------------------------------------------------------------
    | Default User Figure String
    |--------------------------------------------------------------------------
    |
    | This will be used to look your User by Default
    |
    */

    'figure' => 'hr-115-42.hd-195-19.ch-3030-82.lg-275-1408.fa-1201.ca-1804-64',

    /*
    |--------------------------------------------------------------------------
    | Enable ADS for Users
    |--------------------------------------------------------------------------
    |
    | This Setting Will Enable Advertisement for ANY User
    | In order to get it fully working, you need configure the settings above
    |
    */

    'ads' => [
        'enabled'   => false,
        'adseneKey' => 'YOUR-ADSENE-KEY', //DEFAULT: /108596585/HABBO_Video
    ],

    /*
    |--------------------------------------------------------------------------
    | CORS (Access Cross Origin)
    |--------------------------------------------------------------------------
    |
    | Select the Domains that can Access this site.
    |
    */

    'cors' => [
        '*',
    ],

    /*
    |--------------------------------------------------------------------------
    | Max Users
    |--------------------------------------------------------------------------
    |
    | The maximum of avatars that can be created
    |
    */

    'maxAvatars' => 50,

    /*
    |--------------------------------------------------------------------------
    | Twitter Configuration
    |--------------------------------------------------------------------------
    |
    | This will be used to Promote your Twitter
    |
    */

    'twitter' => [
        'title'    => 'Tweets by @YOUR-TWITTER-USERNAME',
        'username' => 'YOUR-TWITTER-USERNAME',
    ],

    /*
    |--------------------------------------------------------------------------
    | Facebook Configuration
    |--------------------------------------------------------------------------
    |
    | This will be used to Promote your Facebook Page
    | This also will be used for Facebook Login
    |
    */

    'facebook' => [
        'page' => 'YOUR-FACEBOOK-PAGE',
        'app'  => [
            'key'    => 'YOUR-API-KEY',
            'secret' => 'YOU-SECRET-KEY',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Youtube Configuration
    |--------------------------------------------------------------------------
    |
    | Used for Social Media
    |
    */

    'youtube' => 'YOUR-YOUTUBE-PAGE',

    /*
    |--------------------------------------------------------------------------
    | Server Language
    |--------------------------------------------------------------------------
    |
    | Hotel Language Setting
    | Available Actually: com, br
    |
    */

    'siteLanguage' => 'com',

    /*
    |--------------------------------------------------------------------------
    | Server Country
    |--------------------------------------------------------------------------
    |
    | Hotel Country Settings
    |
    */

    'location' => [
        'country'   => 'us',
        'continent' => 'na',
    ],

    /*
    |--------------------------------------------------------------------------
    | Habbo Badges Location
    |--------------------------------------------------------------------------
    |
    | Path for Habbo User Badges
    |
    */

    'badgeRepository' => 'https://habboo-a.akamaihd.net/c_images/album1584',

    /*
    |--------------------------------------------------------------------------
    | Invalid Usernames
    |--------------------------------------------------------------------------
    |
    | Invalid User Names for Users
    | Check if User contains something like that
    |
    */

    'invalid' => [
        'MOD_',
        'MOD-',
        'Admin_',
        'ovflowd',
        'sant0ro',
        'saamus',
    ],

    /*
    |--------------------------------------------------------------------------
    | User Default Motto
    |--------------------------------------------------------------------------
    |
    | The Default Text Mission of an User
    |
    */

    'motto' => "I'm an Arcturus Lover!",

    /*
    |--------------------------------------------------------------------------
    | Habbo Imaging Service Provider
    |--------------------------------------------------------------------------
    |
    | Imaging Service Provider
    |
    */
    'imaging' => 'https://www.habbo.de/habbo-imaging/',

    /*
    |--------------------------------------------------------------------------
    | Emulator Settings
    |--------------------------------------------------------------------------
    |
    | Settings for the Emulator Connection
    | Like IP Address & Port
    |
    */

    'emulator' => [
        'address' => '127.0.0.1',
        'port'    => 30000,
    ],

    /*
    |--------------------------------------------------------------------------
    | SWF Settings
    |--------------------------------------------------------------------------
    |
    | Settings for the SWF Configuration
    | Like Gordon Path, Flash File, Etc
    |
    | @Attention.: Arcturus 1.4 uses PRODUCTION-201611291003-338511768
    |
    */

    'game' => [
        'gordon'   => 'http://localhost/public/swf/gordon/PRODUCTION-201611291003-338511768/',
        'flash'    => 'http://localhost/public/swf/gordon/PRODUCTION-201611291003-338511768/Habbo.swf',
        'gamedata' => [
            'figuredata'        => 'http://localhost/public/swf/gamedata/figuredata.xml',
            'furnidata'         => 'http://localhost/public/swf/gamedata/furnidata.xml/',
            'productdata'       => 'http://localhost/public/swf/gamedata/productdata.txt',
            'variables'         => 'http://localhost/public/swf/gamedata/external_variables.txt',
            'texts'             => 'http://localhost/public/swf/gamedata/external_flash_texts.txt',
            'overrideVariables' => 'http://localhost/public/swf/override/external_override_variables.txt',
            'overrideTexts'     => 'http://localhost/public/swf/gamedata/override/external_flash_override_texts.txt',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Loading Screen
    |--------------------------------------------------------------------------
    |
    | Configure the text of Loading Screen.
    |
    */

    'loading' => [
        'Loading Habbo Hotel',
        'See those Yellow Duckies, It\'s Wesley, no?',
        'I would like to eat some chocolate cookies.. You know.',
        'Claudio it\'s you?',
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Security related Settings
    | Like Password Hashing
    |
    | Available Hashes: http://php.net/manual/en/function.hash-algos.php
    |
    */

    'security' => [
        'hash'    => 'sha256',
        'session' => 'ChocolateyWEB',
    ],

    /*
    |--------------------------------------------------------------------------
    | Staff Min Rank
    |--------------------------------------------------------------------------
    |
    | The Minimal Rank that someone it's considered as Staff
    |
    */

    'minRank' => 4,

    /*
    |--------------------------------------------------------------------------
    | Enable Cookies Message
    |--------------------------------------------------------------------------
    |
    | Show the Cookies Banner for first access Users?
    |
    */

    'cookieBanner' => true,
];
