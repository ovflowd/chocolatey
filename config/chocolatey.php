<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Hotel Name
    |--------------------------------------------------------------------------
    |
    | This is the Hotel Name Setting
    | That will be used to visible show your Hotel
    |
    */

    'name' => 'Habbo',

    /*
    |--------------------------------------------------------------------------
    | Hotel URL
    |--------------------------------------------------------------------------
    |
    | This is the Hotel URL Setting
    | That will be used to visible show your Hotel
    |
    */

    'url' => 'http://localhost/',

    /*
    |--------------------------------------------------------------------------
    | Hotel Path
    |--------------------------------------------------------------------------
    |
    | This is used when you're working in subdirectories.
    | WARNING: This is not RECOMMENDED! Chocolatey NEED be INSTALLED on the DocumentRoot ('/')
    | WARNING: This it's only a partial fix!
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Hotel Maintenance
    |--------------------------------------------------------------------------
    |
    | Enable the Hotel Maintenance
    | <To enable Maintenance mode write 'php artisan down'>
    | <To disable Maintenance mode write 'php artisan up'>
    | *those commands need to be written on the console/terminal/cmd*
    |
    */

    // Using this isn't Recommended
    'forceMaintenance' => false,

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
    | Hotel Maintenance
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
        'enabled' => true,
        'adsene-key' => 'YOUR-ADSENE-KEY' //DEFAULT: /108596585/HABBO_Video
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
        '*'
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Configuration
    |--------------------------------------------------------------------------
    |
    | This will be used to Promote your Twitter
    |
    */

    'twitter' => [
        'name' => '@m0vame',
        'username' => 'm0vame',
        'key' => 502480771739684864
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
        'page' => 'universalinternetofthings',
        'app' => [
            'key' => 'YOUR-API-KEY',
            'secret' => ''
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Server Language
    |--------------------------------------------------------------------------
    |
    | Hotel Language Setting
    | Available Actually: com, br
    |
    */

    'language' => 'com',

    'pages-language' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Server Country
    |--------------------------------------------------------------------------
    |
    | Hotel Country Settings
    |
    */

    'location' => [
        'country' => 'us',
        'continent' => 'na'
    ],

    /*
    |--------------------------------------------------------------------------
    | Habbo Badges Location
    |--------------------------------------------------------------------------
    |
    | Path for Habbo User Badges
    |
    */

    'badges' => 'https://habboo-a.akamaihd.net/c_images/album1584',

    /*
    |--------------------------------------------------------------------------
    | Help Website Redirect
    |--------------------------------------------------------------------------
    |
    | Redirect URL
    |
    */

    'help' => 'https://help.habbo.com/',

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
        'saamus'
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
        'port' => 30000
    ],

    /*
    |--------------------------------------------------------------------------
    | SWF Settings
    |--------------------------------------------------------------------------
    |
    | Settings for the SWF Configuration
    | Like Gordon Path, Flash File, Etc
    |
    */

    'game' => [
        'gordon' => 'http://uiotassets.blob.core.windows.net/unity/gordon/PRODUCTION-201601012205-226667486/',
        'flash' => 'http://uiotassets.blob.core.windows.net/unity/gordon/PRODUCTION-201601012205-226667486/Habbo.swf',
        'gamedata' => [
            'figuredata' => 'http://uiotassets.blob.core.windows.net/unity/gamedata/figuredata.xml',
            'furnidata' => 'http://uiotassets.blob.core.windows.net/unity/gamedata/furnidata.xml/',
            'productdata' => 'http://uiotassets.blob.core.windows.net/unity/gamedata/productdata.txt',
            'variables' => 'http://uiotassets.blob.core.windows.net/unity/gamedata/external_variables.txt',
            'texts' => 'http://uiotassets.blob.core.windows.net/unity/gamedata/external_flash_texts.txt',
            'override_variables' => 'http://uiotassets.blob.core.windows.net/unity/gamedata/override/external_override_variables.txt',
            'override_texts' => 'http://uiotassets.blob.core.windows.net/unity/gamedata/override/external_flash_override_texts.txt',
        ]
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
        'hash' => 'sha256',
        'session' => 'ChocolateyWEB'
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable Earn Credits
    |--------------------------------------------------------------------------
    |
    | This will Enable/Disable Earn Credits Promo
    |
    */

    'earn' => true,

    /*
    |--------------------------------------------------------------------------
    | Earn Credits Link
    |--------------------------------------------------------------------------
    |
    | The URL for Earn Credits Promo
    |
    */

    'earn_link' => 'https://www.offertoro.com/ifr/show/2150/s-hhus-bf01d11c861e8785afe95065caa7f182/1308',

    /*
    |--------------------------------------------------------------------------
    | Vote System
    |--------------------------------------------------------------------------
    |
    | Enable/Disable Voting System
    |
    | Pattern.: https://findretros.com/rankings/vote/{VoteName}
    |
    | Warning.: Be sure to configure RETURN URL to
    |               http://your-hotel-name.com/hotel
    |
    */

    'vote' => [
        'enabled' => false,
        'name' => 'Habbo'
    ]
];
