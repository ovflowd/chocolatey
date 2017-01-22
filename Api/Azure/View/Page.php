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

namespace Azure\View;

use Azure\System;
use Azure\User;

/**
 * Class Page
 * This Class Control the Content of the CMS
 * @package Azure\View
 */
final class Page
{
	/**
	 * @var $database_settings Database Settings
	 * @var $cms_settings The CMS Settings That is Registered on
	 * @var $user_data The User Data passed by the Class
	 * @var $lang_content The Content of Lang Files
	 */
	public $database_settings, $cms_settings, $user_data, $lang_content;

	/**
	 * function construct
	 * constructs something? oh the page xdd
	 * @param $database_settings
	 * @param $cms_settings
	 * @param $user_data
	 */
	function __construct($database_settings, $cms_settings, $user_data)
	{
		$this->database_settings = $database_settings;
		$this->cms_settings      = $cms_settings;
		$this->user_data         = $user_data;

	}

	/**
	 * function get
	 * get value of $name
	 * @param $name
	 * @return mixed
	 */
	function __get($name)
	{
		return $this->$name;
	}

	/**
	 * function set
	 * set a value for a variable
	 * @param string $name
	 * @param string $value
	 */
	function __set($name = '', $value = '')
	{
		$this->$name = $value;
	}

	/**
	 * function trace_routers
	 * some magic magic is magic
	 * keep on rising
	 * kidding, trace the content and request content.
	 * @return array
	 */
	function trace_routers()
	{
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
		header("Access-Control-Allow-Origin: *");

		$request_url = explode('/', $_SERVER['REQUEST_URI']);
		$scriptName  = explode('/', $_SERVER['SCRIPT_NAME']);

		for ($i = 0; $i < sizeof($scriptName); $i++)
			if ($request_url[$i] == $scriptName[$i])
				unset($request_url[$i]);

		$command = array_values($request_url);

		switch ($command[0]):
			case 'theallseeingeye':
				$f = ((isset($command[2])) && ($command[2] != '')) ? 'hk_' . Misc::escape_text($command[2]) : 'hk_index';
				break;
			default:
				$f = ((isset($command[0])) && ($command[0] != '')) ? Misc::escape_text($command[0]) : 'index';
				break;
		endswitch;

		if (strpos($command[sizeof($command) - 1], "?") !== false):
			$c                             = explode("?", $command[sizeof($command) - 1]);
			$command[sizeof($command) - 1] = $c[0];
			unset($c[0]);
			$command[] = implode("&", $c);
		endif;

		unset($command[0]);

		foreach ($command as $key => $value):
			if (is_numeric($key)):
				$last = $command[$key - 1];
				if (isset($last) && $last != ''):
					$_GET[$last] = urldecode($value);
					$last        = '';
				endif;
			endif;
		endforeach;

		return $f;
	}

	/**
	 * function make_page
	 * make a page :)
	 * @param string $page_name
	 * @return string
	 */
	function create_page($page_name = 'index')
	{
		return ($this->cms_settings['maintenance'] == 0) ? $this->render_page($page_name) : $this->render_page('maintenance');
	}

	/**
	 * function render_page
	 * render content of the mvc
	 * @param string $page_id
	 * @return string
	 */
	function render_page($page_id = 'index')
	{
		if (INSTALLED):
			switch ($page_id) :
				case "client":
					return $this->include_content('client');
				case "client_new":
					return $this->include_content('client_new');
				case "error":
				case "maintenance":
					return $this->include_content('header', 'sub') . $this->include_content('error') . $this->include_content('footer', 'sub');
				case "upgrade":
					return $this->include_content('header', 'sub') . $this->include_content('upgrade') . $this->include_content('footer', 'sub');
				case "hk_index":
					return $this->include_content('header', 'ase/sub') . $this->include_content('index', 'ase') . $this->include_content('footer', 'ase/sub');
				case "hk_user":
					return $this->include_content('header', 'ase/sub') . $this->include_content('index', 'ase/user') . $this->include_content('footer', 'ase/sub');
				case "hk_uedit":
					return $this->include_content('header', 'ase/sub') . $this->include_content('edit', 'ase/user') . $this->include_content('footer', 'ase/sub');
				case "hk_staff":
					return $this->include_content('header', 'ase/sub') . $this->include_content('staff', 'ase/user') . $this->include_content('footer', 'ase/sub');
				case "hk_accounts":
					return $this->include_content('header', 'ase/sub') . $this->include_content('accounts', 'ase/user') . $this->include_content('footer', 'ase/sub');
				case "hk_voucher":
					return $this->include_content('header', 'ase/sub') . $this->include_content('voucher', 'ase/user') . $this->include_content('footer', 'ase/sub');
				case "hk_logs":
					return $this->include_content('header', 'ase/sub') . $this->include_content('logs', 'ase/user') . $this->include_content('footer', 'ase/sub');
				case "hk_bans":
					return $this->include_content('header', 'ase/sub') . $this->include_content('bans', 'ase/user') . $this->include_content('footer', 'ase/sub');
				case "hk_chatlog":
					return $this->include_content('header', 'ase/sub') . $this->include_content('chatlog', 'ase/user') . $this->include_content('footer', 'ase/sub');
				case "hk_uonline":
					return $this->include_content('header', 'ase/sub') . $this->include_content('uonline', 'ase/user') . $this->include_content('footer', 'ase/sub');
				case "hk_site":
					return $this->include_content('header', 'ase/sub') . $this->include_content('index', 'ase/site') . $this->include_content('footer', 'ase/sub');
				case "hk_server":
					return $this->include_content('header', 'ase/sub') . $this->include_content('index', 'ase/server') . $this->include_content('footer', 'ase/sub');
				case "hk_login":
					return $this->include_content('header', 'ase/sub') . $this->include_content('login', 'ase') . $this->include_content('footer', 'ase/sub');
				case "hk_articles":
					return $this->include_content('header', 'ase/sub') . $this->include_content('articles', 'ase/site') . $this->include_content('footer', 'ase/sub');
				case "hk_promos":
					return $this->include_content('header', 'ase/sub') . $this->include_content('promos', 'ase/site') . $this->include_content('footer', 'ase/sub');
				case 'shopapi':
					return $this->include_content('pay', 'shopapi');
				case 'index':
				default:
					return $this->include_content('index');
			endswitch;
		else:
			switch ($page_id):
				case 'index':
					return $this->include_content('header', 'install/sub') . $this->include_content('index', 'install') . $this->include_content('footer', 'install/sub');
				case 'database':
					return $this->include_content('header', 'install/sub') . $this->include_content('database', 'install') . $this->include_content('footer', 'install/sub');
				case 'settings':
					return $this->include_content('header', 'install/sub') . $this->include_content('settings', 'install') . $this->include_content('footer', 'install/sub');
				case 'installation':
					return $this->include_content('header', 'install/sub') . $this->include_content('installation', 'install') . $this->include_content('footer', 'install/sub');
				case 'administration':
					return $this->include_content('header', 'install/sub') . $this->include_content('administration', 'install') . $this->include_content('footer', 'install/sub');
				case 'finish':
					return $this->include_content('header', 'install/sub') . $this->include_content('finish', 'install') . $this->include_content('footer', 'install/sub');
				default:
					return $this->include_content('header', 'install/sub') . $this->include_content(str_replace('error?', '', $page_id), 'install/error') . $this->include_content('footer', 'install/sub');
			endswitch;
		endif;
	}

	/**
	 * function serialize
	 * serialize content
	 * @param string $wait_serialize
	 * @return mixed
	 */
	function serialize_page($wait_serialize = '')
	{
		// lang serialize
		$this->load_json(Data::$system_instance->server_lang);

		// foreach lang data
		foreach ($this->lang_content as $key => $value)
			$wait_serialize = (strpos($wait_serialize, '{{lang_' . strtolower($key) . '}}') != false) ? str_replace('{{lang_' . strtolower($key) . '}}', $value, $wait_serialize) : $wait_serialize;

		// foreach user data
		foreach ($this->user_data as $key => $value)
			$wait_serialize = (strpos($wait_serialize, '{{' . strtolower($key) . '}}') != false) ? str_replace('{{' . strtolower($key) . '}}', $value, $wait_serialize) : $wait_serialize;

		// foreach settings data
		foreach ($this->cms_settings as $key => $value)
			$wait_serialize = (strpos($wait_serialize, '{{' . strtolower($key) . '}}') != false) ? str_replace('{{' . strtolower($key) . '}}', $value, $wait_serialize) : $wait_serialize;

		// foreach system data
		foreach (System::get_system_class() as $key => $value)
			$wait_serialize = (strpos($wait_serialize, '{{' . strtolower($key) . '}}') != false) ? str_replace('{{' . strtolower($key) . '}}', $value, $wait_serialize) : $wait_serialize;

		// for the client..
		$wait_serialize = (strpos($wait_serialize, '{{client_tick}}') != false) ? str_replace('{{client_tick}}', User::generate_ticket(), $wait_serialize) : $wait_serialize;
		$wait_serialize = (strpos($wait_serialize, '{{user_data}}') != false) ? str_replace('{{user_data}}', ((Data::check_if_user_exists()) ? Data::$user_instance->get_user_data(4) : 'null'), $wait_serialize) : $wait_serialize;
		$wait_serialize = (strpos($wait_serialize, '{{user_hash}}') != false) ? str_replace('{{user_hash}}', User::user_hash(), $wait_serialize) : $wait_serialize;

		// let's go
		return $wait_serialize;
	}

	/**
	 * function load_json
	 * load json data
	 * @param string $server_lang
	 */
	private function load_json($server_lang = 'en')
	{
		$this->lang_content = json_decode(file_get_contents(ROOT_PATH . "/Public/web-img/lang/{$server_lang}.json"), true);
	}

	/**
	 * function render_content
	 * make i love me
	 * opss, make the ob content xdd
	 * @param string $template
	 * @param string $path
	 * @return string
	 */
	static function include_content($template = 'index', $path = '')
	{
		ob_start();

		include_once(ROOT_PATH . "/Templates/{$path}/{$template}.html");

		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
