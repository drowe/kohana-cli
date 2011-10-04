<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Command_Generate class to generate basic kohana constructs
 *
 * @package Kohana-Cli
 * @author Ivan K
 **/
class Command_Generate extends Command
{
	const MODULE_BRIEF = "Generate a module stup";
	const MODULE_DESC = "Generate a module with ./kohana generate <module-name> Optional params are --guide and --init which will generate those stubs of the module for you";
	
	public function module($name)
	{
		$module_name = str_replace("/","-", $name);
		$module_title = ucfirst(Inflector::humanize($module_name));
		$options = CLI::options("guide", "init");

		if( ! is_dir(MODPATH.$name))
			mkdir(MODPATH.$name, 0777, true);

		if( ! is_dir(MODPATH.$name.DIRECTORY_SEPARATOR.'classes'))
			mkdir(MODPATH.$name.DIRECTORY_SEPARATOR.'classes', 0777, true);

		if( ! is_dir(MODPATH.$name.DIRECTORY_SEPARATOR.'config'))
			mkdir(MODPATH.$name.DIRECTORY_SEPARATOR.'config', 0777, true);

		if( ! is_dir(MODPATH.$name.DIRECTORY_SEPARATOR.'tests'))
			mkdir(MODPATH.$name.DIRECTORY_SEPARATOR.'tests', 0777, true);

		$this->set_template(
			MODPATH.$name.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$module_name.EXT,
			'module_config'
		);

		$this->log("Generated directory structure", Command::OK);

		if( array_key_exists('guide', $options))
		{
			mkdir(MODPATH.$name.DIRECTORY_SEPARATOR.'guide'.DIRECTORY_SEPARATOR.$module_name, 0777, true);

			$this->set_template(
				MODPATH.$name.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'userguide'.EXT,
				'module_userguide_config',
				 array('{module_name}' => $module_name, '{module_title}' => $module_title)
			);

			$this->set_template(
				MODPATH.$name.DIRECTORY_SEPARATOR.'guide'.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR.'index.md',
				'module_userguide_menu',
				 array('{module_title}' => $module_title)
			);

			$this->set_template(
				MODPATH.$name.DIRECTORY_SEPARATOR.'guide'.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR.'menu.md',
				'module_userguide_index',
				 array('{module_title}' => $module_title)
			);

			$this->log("Generated guide", Command::OK);
		}
		if( array_key_exists('init', $options))
		{
			$this->set_template(
				MODPATH.$name.DIRECTORY_SEPARATOR."init".EXT,
				'module_init'
			);

			$this->log("Generated init file", Command::OK);
		}

		$this->log("Generated module $module_name in ".MODPATH.$name, Command::OK);
	}
}
