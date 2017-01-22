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
use Azure\View\Data;
use Azure\View\Page;

/**
 * Class Framework
 * @package Azure
 */
final class Framework
{
	/**
	 * @var
	 */
	/**
	 * @var array
	 */
	/**
	 * @var array
	 */
	public $database, $page = '', $white_list = [];

	/**
	 * function construct
	 * create your life
	 * @param bool $render_page
	 */
	function __construct($render_page = true)
	{
		// white list can every time access
		$this->white_list = [
			'127.0.0.1',
			'::1',
			'localhost'
		];

		$this->start_database();
		$this->load_page($render_page);
	}

	/**
	 * function start_database
	 * create database socket
	 */
	function start_database()
	{
		$this->database = (Adapter::get_instance() != null) ? Adapter::get_instance() : Adapter::set_instance(unserialize(DATABASE_SETTINGS));
	}

	/**
	 * function check_installation
	 * check the existence of installed azureweb
	 */
	function check_installation()
	{
		if (!INSTALLED && (!in_array($_SERVER['REMOTE_ADDR'], $this->white_list)))
			Framework::ux_die("[installer] only owner can access when install is activated.");
	}

	/**
	 * function load_page
	 * load the page
	 * @param bool $render_page
	 */
	private function load_page($render_page = true)
	{
		$this->check_installation();
		// collect user and system data
		$init = (Data::check_if_user_exists()) ? Data::$user_instance : null;
		// universalize the settings
		$page = new Page($database_settings = unserialize(DATABASE_SETTINGS), $system_settings = unserialize(SYSTEM_SETTINGS), $init);
		// start cms settings
		Data::system_create_instance($system_settings['server_lang']);
		// check of banned user
		User::check_banned_account();
		// set the page & store page data
		if ($render_page)
			$this->page = $this->page . ($page->serialize_page($page->create_page($page->trace_routers())));
		// let's do benchmark
		if ($system_settings['bench_enabled'])
			$this->page = $this->page . "<!-- \r\n" . Benchmark::run(false) . " \r\n -->";
		// oke!
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
	 * set a $value for the the variable $name
	 * @param $name
	 * @param $value
	 */
	function __set($name, $value)
	{
		$this->$name = $value;
	}

	/**
	 * function get_instance
	 * return framework instance
	 * @return $this
	 */
	function get_instance()
	{
		return $this;
	}

	/**
	 * @param string $message_content
	 * @param bool $need_die
	 */
	static function ux_die($message_content = "", $need_die = true)
	{
		echo str_replace('{{error_message}}', $message_content, Page::include_content('error', 'sub'));
		if ($need_die)
			die();
	}

	/**
	 * function destruct
	 * destroy your life ;)
	 */
	function __destruct()
	{
		$this->database = (null);
		$this->page     = (null);
	}
}
