<?php

namespace App\Helpers;

/* Avoids CloudFlare IP to be logged as users IP */

if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}
