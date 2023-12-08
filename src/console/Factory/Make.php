<?php

namespace Sienekib\Mehael\Console\Factory;

class Make
{
	private static array $options = [
		'controller', 
		'model',
		'seeder',
		'migration',
		'class',
		'middleware'
	];

	public function __construct()
	{
	}

	public static function controller($argv)
	{
		var_dump('aqqqui');exit;
	}

	public static function optionExists(string $option)
	{
		foreach (static::$options as $opt) {
			if ($option == $opt) {
				return true;
			}
		}
		return false;
	}
}