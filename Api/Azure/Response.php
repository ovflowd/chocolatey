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

namespace Azure;

use Azure\Database\Adapter;
use Azure\View\Misc;

/**
 * Class Response
 * @package Azure
 */
final class Response
{

    /**
     * @var string
     */
    private $path = '', $data = 'none', $api = 'ADefault', $cmd;

    /**
     * function construct
     * get the request controller
     */
    function __construct()
    {
        // set name-types to utf-8 without bom.
        Adapter::query("SET NAMES 'utf8'");

        // route the params
        $this->router_params();
        $this->handle();

        // echo the show of controller
        echo $this->send();
    }

    /**
     * function router_params
     * get the inputted url and create a array to define the exactly requested controller
     */
    function router_params()
    {
        // Header Statements
        header('Cache-Control: no-cache');
        header('Pragma: no-cache');
        header("Access-Control-Allow-Origin: *");

        // Check if some $_GET indexes is present.
        $this->data = isset($_GET['data']) ? Misc::escape_text($_GET['data']) : $this->data;
        $this->data = isset($_GET['name']) ? Misc::escape_text($_GET['name']) : $this->data;
        $this->api = isset($_GET['api']) ? Misc::escape_text($_GET['api']) : $this->api;

        // Our Request URL
        $request_url = $_SERVER['REQUEST_URI'];

        // Check if Exists some GET
        if (strpos($request_url, '?') !== false)
            $request_url = strstr($request_url, '?', true);

        // Explode the request_url to a Array
        $request_url = explode('/', $request_url);
        $script_name = explode('/', $_SERVER['SCRIPT_NAME']);

        // Verify the Requested URL
        for ($i = 0; $i < sizeof($script_name); $i++)
            if ($request_url[$i] == $script_name[$i])
                unset($request_url[$i]);

        $command = array_values($request_url);

        // We will uniform the Requested URL
        foreach ($command as $key => $value):

            if (strpos($value, '_') !== false):
                $l = explode('_', $value);

                foreach ($l as $key2 => $value2)
                    $l[$key2] = ucfirst($l[$key2]);

                $l = str_replace('_', '', implode('_', $l));
                $command[$key] = $l;
                $l = null;

            elseif (strpos($value, '-') !== false):
                $l = explode('-', $value);

                foreach ($l as $key2 => $value2)
                    $l[$key2] = ucfirst($l[$key2]);

                $l = str_replace('-', '', implode('-', $l));
                $command[$key] = $l;
                $l = null;
            else:
                $command[$key] = ucfirst($command[$key]);
            endif;

        endforeach;

        // Saving the Array
        $this->cmd = $command;
    }

    /**
     * function handle
     * handle request and does the route and check of controller existence
     */
    function handle()
    {
        if (INSTALLED):
            if ($this->api == 'ADefault')
                $this->recursive((ROOT_PATH . '/Api/Azure/Controllers/'), 'ADefault/', ($this->cmd), 1, (count($this->cmd) - 1));
            else if ($this->api == 'AHobbaNet')
                $this->recursive((ROOT_PATH . '/Api/Azure/Controllers/'), 'AHobbaNet/', ($this->cmd), 1, (count($this->cmd) - 1));
            else
                $this->path = '/Azure/Controllers/' . ($this->api);
            $this->path = str_replace('/', '\\', $this->path);
        else:
            $this->recursive((ROOT_PATH . '/Api/Azure/Controllers/'), 'ACore/', ($this->cmd), 1, (count($this->cmd) - 1));
            $this->path = str_replace('/', '\\', $this->path);
        endif;
    }

    /**
     * function recursive
     * check if the path exists and the controller too
     * @param $root_path
     * @param $path
     * @param $array
     * @param $actual_key
     * @param $max_key
     */
    private function recursive($root_path = '/Api/Azure/Controllers/', $path = '', $array = [], $actual_key = 1, $max_key = 1)
    {
        if (empty($array[$max_key]))
            $array[$max_key] = 'index';

        if (is_dir($root_path . $path . 'A' . ($array[$actual_key]) . '/')):
            if ((!is_file($root_path . $path . 'A' . ($array[$actual_key]) . '/' . ($array[$actual_key + 1]) . '.php')) && (!is_dir($root_path . $path . 'A' . ($array[$actual_key]) . '/' . 'A' . ($array[$actual_key + 1]) . '/'))):
                $this->path = '/Azure/Controllers/' . ($path . ($array[$actual_key]));
            elseif (is_file($root_path . $path . ($array[$actual_key]) . '.php') && ($actual_key == $max_key)):
                $this->path = '/Azure/Controllers/' . ($path . ($array[$actual_key]));
            elseif ($actual_key != $max_key):
                $this->recursive($root_path, ($path . 'A' . ($array[$actual_key]) . '/'), $array, ($actual_key + 1), $max_key);
            else:
                $this->recursive($root_path, ($path . 'A' . ($array[$actual_key]) . '/'), $array, ($actual_key), $max_key);
            endif;
        else:
            if (is_file($root_path . $path . 'A' . ($array[$actual_key]) . '.php')):
                $this->path = '/Azure/Controllers/' . ($path . 'A' . ($array[$actual_key]));
            elseif (is_file($root_path . $path . ($array[$actual_key]) . '.php')):
                $this->path = '/Azure/Controllers/' . ($path . ($array[$actual_key]));
            endif;
        endif;

        if (($actual_key != $max_key) && (!empty($this->path)) && ($this->data == 'none')):
            $array = array_slice($array, $actual_key + 1);
            $this->data = implode('/', $array);
        elseif (($actual_key == $max_key) && (!empty($this->path)) && ($this->data == 'none')):
            $this->data = $array[$actual_key];
        endif;
    }

    /**
     * function send
     * initialize the class and send the request
     * @return bool
     */
    function send()
    {
        if ($this->path != ''):
            $response = new $this->path($this->data);
            return $response->show($this->data);
        endif;
        Framework::ux_die("[application] exception: controller doesn't Exists.");
        return false;
    }

    /**
     * destroy all variables.
     */
    function __destruct()
    {
        $this->path = (null);
        $this->cmd = (null);
        $this->data = (null);
        $this->api = (null);
    }
}