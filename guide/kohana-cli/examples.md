# Cache sweeper

	<?php defined('SYSPATH') or die('No direct script access.');

	class Command_Cache extends Command
	{
		const CLEAR_BRIEF = "Clear system cache and Cache";
		public function clear()
		{
			self::log_func(array(Cache::instance(), 'delete_all'), null, Command::OK);
			self::log_func("system", array("rm -rf ".Kohana::$cache_dir."/*"), Command::OK);
		}

	}

So you can access it like this 

	./kohana cache:clear

# Generate Model File

	<?php defined('SYSPATH') or die('No direct script access.');

	class Command_Generate extends Command
	{
		const MODEL_BRIEF = "Generate a user model";
		
		const MODEL_DESC = "Generate a user model file, you must provide the name of the file as argument, optionally you can add a --module to generate this class inside a module, otherwise it will be generated in the application folder.";

		public function model($name = null)
		{
			if( ! $name)
				throw new Kohana_Exception("Please set a name for the model ( generate:model <name> )");
			
			//Use Kohana's options parser to get an optional module
			$options = CLI::options('module');

			$prefix = isset($options['module']) ? MODPATH.$options['module'].DIRECTORY_SEPARATOR : APPPATH;
			$dir = $prefix.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'model';

			$template = file_get_contents(Kohana::find_file('templates', 'migration', 'tpl'));

			if( ! is_dir($dir))
			{
				mkdir($dir, 0777, true);
			}

			file_put_contents($dir.DIRECTORY_SEPARATOR.$name.EXT, strtr($template, array( '{class_name}' => ucfirst($name))));  

			self::log("$dir/$name".EXT." Generated", Command::OK);
		}
	}

So you can generate a model file like this 

	./kohana generate:model user --module=users