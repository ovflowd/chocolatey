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

    'url' => 'http://localhost:8888/',

    /*
    |--------------------------------------------------------------------------
    | Twitter Configuration
    |--------------------------------------------------------------------------
    |
    | This will be used to Promote your Twitter
    |
    */

    'twitter' => [
        'name' => '@Habbo',
        'key' => null
    ],

    /*
    |--------------------------------------------------------------------------
    | Server Language
    |--------------------------------------------------------------------------
    |
    | Hotel Language Setting
    | Available Actually: com
    |
    */

    'language' => 'com',

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
