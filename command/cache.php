<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Command_Cache class a simple command to clear cache
 *
 * @package Kohana-Cli
 * @author Ivan K
 **/
class Command_Cache extends Command
{

	const CLEAR_BRIEF = "Clear system cache and Cache";
	public function clear()
	{
		self::log_func(array(Cache::instance(), 'delete_all'), null, Command::OK);
		self::log_func("system", array("rm -rf ".Kohana::$cache_dir."/*"), Command::OK);
	}
}
