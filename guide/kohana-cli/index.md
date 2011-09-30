# Getting started

This module offers the ability to quickly create command line interfaces for your project

* Symlink / copy "kohana" file into your main directory or to your bin path
* Create a folder "command" in any of your modules (including application)
* create a file with the name of the command and a classname of "Command_{name} extends Command"
* write methods

Each method accepts unlimited number of attributes after its name on the command line

## Example

	// application/command/script.php
	class Command_Script extends Command{
		public function fix_bug
		{
			// Code ...
		}
	}

You call this method with

	./kohana script:fix:bug

The default command name is "index", so "	./kohana script" executes Command_Script::index

# Command class

THe Command class has some perks to help you - the "log" method will output content immediately
and has a "color" as a second attribute

	Command::log("This is red text", "red");
	Command::log("This is green text", "green");

You can also mix colors in a single line

	Command::log(Command::colored("This is yellow text", "yellow"). "normal text ".Command::colored("inverted", "black", "white"));

You can also easily benchmark time of execution for a function with "log_func" - you provide method array / function name string. It gets run and displays the time it took to run it.

	Command::log_func(array(Cache::instance(), "delete_all"), null, "green");

For more consistant colors you can use Command::OK, Command::WARNING and Command::ERROR constants.	

# Run Commands

	./kohana
	./kohana list
	./kohana help {command}
	./kohana {command}

# Descriptions and Briefs

For each method in the command class you can add a constant string with the method name and ending with _BRIEF or _DESC. It will be displayed in the list and help respectively

## Example

	// application/command/script.php
	class Command_Script extends Command{

		const FIX_BUG_BRIEF = "This is a fix bug command";
		const FIX_BUG_DESC = "This is a proper explanation of the command explaining all the options and arguments supported by it";
		public function fix_bug
		{
			// Code ...
		}
	}


	