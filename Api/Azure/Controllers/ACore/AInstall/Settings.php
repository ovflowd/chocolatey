<?php

/*
 * * azure project presents:
                                          _
                                         | |
 __,   __          ,_    _             _ | |
/  |  / / _|   |  /  |  |/    |  |  |_|/ |/ \_
\_/|_/ /_/  \_/|_/   |_/|__/   \/ \/  |__/\_/
        /|
        \|
				azure web
				version: 1.0a
				azure team
 * * be carefully.
 */

namespace Azure\Controllers\ACore\AInstall;

use Azure\Types\Controller as ControllerType;
use Azure\View\Misc;

/**
 * Class Settings
 * @package Azure\Controllers\ACore\AInstall
 */
class Settings extends ControllerType
{

    /**
     * function construct
     * create a controller for shop purse
     */

    function __construct()
    {

    }

    /**
     * function show
     * render and return content
     */
    function show()
    {
        if (!INSTALLED):
            $hotel_settings = [
                'bench_enabled' => false,
                'server_lang' => 'en',
                'maintenance' => 0,
                'smtp_server' => 'localhost',
                'global_url' => Misc::escape_text($_POST['hotel_url']),
                'hotel_name' => Misc::escape_text($_POST['hotel_name']),
                'hotel_url' => '',
                'emu_type' => Misc::escape_text($_POST['emulator_type']),
                'client_newbie_name' => 'client_new/',
                'badge_url' => 'https://images.habbo.com/c_images/album1584/',
                'imaging_url' => 'https://habbo.de/habbo-imaging/',
                'gallery_url' => Misc::escape_text($_POST['gallery_url']),
                'swf_url' => Misc::escape_text($_POST['swf_url']),
                'random_stuff' => 's' . rand(0, 9) . 'a' . rand(0, 9) . 'm' . rand(0, 100),
                'client_name' => 'client/',
                'emu_ip' => Misc::escape_text($_POST['emu_ip']),
                'emu_port' => Misc::escape_text($_POST['emu_port']),
                'twitter_on' => 'visible',
                'twitter_username' => Misc::escape_text($_POST['twitter_name']),
                'twitter_id' => Misc::escape_text($_POST['twitter_id']),
                'pay_pal_url' => 'www.paypal.com/order/4535535/'
            ];

            $c = file_get_contents(ROOT_PATH . "/Api/Gogo.php");
            if (strpos($c, '$hotel_settings = array') == false):
                $d = ''
                    . "\n"
                    . '//hotel settings ' . "\n"
                    . "\n"
                    . '$hotel_settings = ' . var_export($hotel_settings, true) . ';' . "\n"
                    . "\n"
                    . "\n";
                $c = '// define constants ' . "\n"
                    . 'defined(\'ROOT_PATH\') || define(\'ROOT_PATH\', realpath(dirname(__FILE__) . \'/../\'));' . "\n"
                    . 'defined(\'DATABASE_SETTINGS\') || define(\'DATABASE_SETTINGS\', serialize($database_settings));' . "\n"
                    . 'defined(\'SYSTEM_SETTINGS\') || define(\'SYSTEM_SETTINGS\', serialize($hotel_settings));' . "\n"
                    . 'defined(\'EMULATOR_TYPE\') || define(\'EMULATOR_TYPE\', $hotel_settings[\'emu_type\']);' . "\n"
                    . "\n";
                file_put_contents(ROOT_PATH . '/Api/Gogo.php', $d, FILE_APPEND);
                file_put_contents(ROOT_PATH . '/Api/Gogo.php', $c, FILE_APPEND);
            endif;
            header("Location: /installation");
            return;
        endif;
        header("Location: /");
        return;
    }
}
