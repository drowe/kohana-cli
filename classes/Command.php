<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Command
 *
 * A class to be extended by all commands in the application, provides some logging methods
 *
 * @package		Kohana-Cli
 * @author		Ivan K
 */
class Command
{
	// Query types
	const ERROR = 'light_red';
	const OK =  'green';
	const WARNING = 'brown';

	static private $foreground_colors = array(
		'black' => '0;30',
		'dark_gray' => '1;30',
		'blue' => '0;34',
		'light_blue' => '1;34',
		'green' => '0;32',
		'light_green' => '1;32',
		'cyan' => '0;36',
		'light_cyan' => '1;36',
		'red' => '0;31',
		'light_red' => '1;31',
		'purple' => '0;35',
		'light_purple' => '1;35',
		'brown' => '0;33',
		'yellow' => '1;33',
		'light_gray' => '0;37',
		'white' => '1;37',
	);

	static private $background_colors = array(
		'black' => '40',
		'red' => '41',
		'green' => '42',
		'yellow' => '43',
		'blue' => '44',
		'magenta' => '45',
		'cyan' => '46',
		'light_gray' => '47',
	);

	/**
	 * Return a string surrounded by shell color codes, if cli.colorize is set to false, show without colors
	 * @param string $string
	 * @param string $foreground_color
	 * @param string $background_color
	 * @return string
	 * @author Ivan K
	 **/
	static public function colored($string, $foreground_color = null, $background_color = null) {
		if( ! Kohana::$config->load('cli.colorize'))
			return $string;

		$colored_string = "";

		// Check if given foreground color found
		if (isset(self::$foreground_colors[$foreground_color])) {
			$colored_string .= "\033[" . self::$foreground_colors[$foreground_color] . "m";
		}
		// Check if given background color found
		if (isset(self::$background_colors[$background_color])) {
			$colored_string .= "\033[" . self::$background_colors[$background_color] . "m";
		}

		// Add string and end coloring
		$colored_string .=  $string . "\033[0m";

		return $colored_string;
	}	

	/**
	 * Echo a string with color as a second parameter
	 * @param string $string
	 * @param string $type ( color )
	 * @return void
	 * @author Ivan K
	 **/
	static public function log($string, $type = null)
	{
		if($type)
		{
			echo self::colored($string, $type)."\n";
		}
		else
		{
			echo $string."\n";	
		}
		ob_flush();
	}

	/**
	 * Generate a file from a template in a "templates" directory with a .tpl extension
	 * @param string $name 
	 * @param array $decorations substitutions 
	 * @return string 
	 */
	static public function set_template($filename, $name, $decorations = null)
	{
		$template_filename = Kohana::find_file('templates', $name, 'tpl');

		if( ! $template_filename )
			throw new Kohana_Exception("Kohana Exception does not exist: :name", array(":name" => $name));
		
		$template = file_get_contents($template_filename);

		if( $decorations )
		{
			$template = strtr($template, $decorations);   
		}
		if( ! is_file($filename))
			file_put_contents($filename, $template);
	}

	/**
	 * Perform a function and echo on start and finish, displaying the time spent
	 * @param string|array $func A callable string / array of class and method name
	 * @param array $args An array of arguments to pass to the function
	 * @param string $type (color)
	 * @return void
	 * @author Ivan K
	 */
	static public function log_func($func, $args = null, $type = null)
	{
		$args_string = array();
		foreach((array) $args as $arg)
		{
			$args_string[] = (string) $arg;
		}

		$func_string = $func;
		if(is_array($func))
		{
			$func_string = (is_object($func[0]) ? get_class($func[0]) : $func[0]).'->'.$func[1];
		}

		self::log("-- $func_string". ($args ? "( ".join(', ', $args_string)." )" : ''), $type);

		$start = microtime(TRUE);

		call_user_func_array($func, (array) $args);

		$end = microtime(TRUE);

		self::log('   --> '.number_format($end-$start, 4).'s', $type);
	}	
}