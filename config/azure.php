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
        'gordon' => 'http://127.0.0.1/swf/gordon/',
        'flash' => 'http://127.0.0.1/swf/gordon/Habbo.swf',
        'gamedata' => [
            'variables' => 'http://127.0.0.1/swf/gamedata/variables.txt',
            'texts' => 'http://127.0.0.1/swf/gamedata/flash_texts.txt',
            'override_variables' => 'http://127.0.0.1/swf/gamedata/override_variables.txt',
            'override_texts' => 'http://127.0.0.1/swf/gamedata/override_flash_texts.txt',
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
