<?php

/*
##########################################################################
#                      PHP Benchmark Performance Script                  #
#                         © 2010 Code24 BV                               #
#                                                                        #
#  Author      : Alessandro Torrisi                                      #
#  Company     : Code24 BV, The Netherlands                              #
#  Date        : July 31, 2010                                           #
#  version     : 1.0.1                                                   #
#  License     : Creative Commons CC-BY license                          #
#  Website     : http://www.php-benchmark-script.com                     #
#                                                                        #
##########################################################################
*/

namespace Azure;

/**
 * Class Benchmark
 * @package Azure
 */
final class Benchmark
{
    /**
     * @param bool $echo
     * @return string
     */
    static function run($echo = true)
    {
        $total = 0;
        $server = (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '?') . '@' . (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '?');
        $methods = get_class_methods('\Azure\Benchmark');
        $line = str_pad("-", 38, "-");
        $return = "$line\n|" . str_pad("AZURE BENCHMARK SCRIPT", 36, " ", STR_PAD_BOTH) . "|\n$line\nStart : " . date("Y-m-d H:i:s") . "\nServer : $server\nPHP version : " . PHP_VERSION . "\nPlatform : " . PHP_OS . "\n$line\n";

        foreach ($methods as $method)
            if (preg_match('/^test_/', $method)):
                $total += $result = self::$method();
                $return .= str_pad($method, 25) . " : " . $result . " sec.\n";
            endif;

        $return .= str_pad("-", 38, "-") . "\n" . str_pad("Total time:", 25) . " : " . $total . " sec.";

        if ($echo)
            echo $return;

        return $return;
    }

    /**
     * @param int $count
     * @return string
     */
    private static function test_math($count = 140000)
    {
        $time_start = microtime(true);
        $math_functions = ["abs", "acos", "asin", "atan", "bindec", "floor", "exp", "sin", "tan", "pi", "is_finite", "is_nan", "sqrt"];

        foreach ($math_functions as $key => $function)
            if (!function_exists($function)) unset($math_functions[$key]);

        for ($i = 0; $i < $count; $i++)
            foreach ($math_functions as $function)
                $r = call_user_func_array($function, [$i]);

        return number_format(microtime(true) - $time_start, 3);
    }

    /**
     * @param int $count
     * @return string
     */
    private static function test_string_manipulation($count = 130000)
    {
        $time_start = microtime(true);
        $string_functions = ["addslashes", "chunk_split", "metaphone", "strip_tags", "md5", "sha1", "strtoupper", "strtolower", "strrev", "strlen", "soundex", "ord"];

        foreach ($string_functions as $key => $function)
            if (!function_exists($function)) unset($string_functions[$key]);

        $string = "the quick brown fox jumps over the lazy dog";

        for ($i = 0; $i < $count; $i++)
            foreach ($string_functions as $function)
                $r = call_user_func_array($function, array($string));

        return number_format(microtime(true) - $time_start, 3);
    }

    /**
     * @param int $count
     * @return string
     */
    private static function test_loops($count = 19000000)
    {
        $time_start = microtime(true);

        for ($i = 0; $i < $count; ++$i) ;

        $i = 0;

        while ($i < $count)
            ++$i;

        return number_format(microtime(true) - $time_start, 3);
    }

    /**
     * @param int $count
     * @return string
     */
    private static function test_conditions($count = 9000000)
    {
        $time_start = microtime(true);

        for ($i = 0; $i < $count; $i++)
            if ($i == -1) ;
            elseif ($i == -2) ;
            elseif ($i == -3) ;
            else;

        return number_format(microtime(true) - $time_start, 3);
    }
}