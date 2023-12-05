<?php

namespace Sienekib\Mehael\Console;

use Sienekib\Mehael\Console\Factory\AlquimistCommand as Commands;

class Alquimist
{
	public function execute($argv, $argc)
	{
		if ($argc < 2 && !isset($argv[1]) )
			die ('Commando desconhecido');
		
		unset($argv[0]);

		$action = explode(':', $argv[1])[0];

		$commands = new Commands();

		if (! method_exists($commands, $action))
			die ('Invalid called method');
		
		return $commands->$action($argv);

	}
}