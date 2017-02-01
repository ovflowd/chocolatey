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

    'name' => 'Habbo Hotel',

    /*
    |--------------------------------------------------------------------------
    | Hotel URL
    |--------------------------------------------------------------------------
    |
    | This is the Hotel URL Setting
    | That will be used to visible show your Hotel
    |
    */

    'url' => 'http://localhost:8887/',

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
        'http://imasdk.googleapis.com',
        'http://127.0.0.1',
        'http://localhost'
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
    | Contact E-mail
    |--------------------------------------------------------------------------
    |
    | This is the E-Mail of the Contact
    | This E-Mail is used for Sending E-Mails too
    |
    */

    'contact' => 'santoro@inboxalias.com',

    /*
    |--------------------------------------------------------------------------
    | User Default Motto
    |--------------------------------------------------------------------------
    |
    | The Default Text Mission of an User
    |
    */

    'motto' => "I'm an Azure Lover!",

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
            'figuredata' => 'https://uiotassets.blob.core.windows.net/unity/gamedata/figuredata.xml',
            'furnidata' => 'http://uiotassets.blob.core.windows.net/unity/gordon/PRODUCTION-201601012205-226667486/',
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
    */

    'security' => [
        'hash' => 'md5',
        'session' => 'azureWEB'
    ]
];
