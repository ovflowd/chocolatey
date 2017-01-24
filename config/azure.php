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
