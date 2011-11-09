<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Command_Cache class a simple command to clear cache
 *
 * @package    OpenBuildings/timestamped-migrations
 * @author     Ivan K
 * @copyright  (c) 2011 OpenBuildings Inc.
 * @license    http://creativecommons.org/licenses/by-sa/3.0/legalcode
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
