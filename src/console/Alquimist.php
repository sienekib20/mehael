<?php

namespace Sienekib\Mehael\Console;

use Sienekib\Mehael\Console\Factory\AlquimistCommand as Commands;

class Alquimist
{
	public function execute($argv, $argc)
	{				
		return (new Commands())->run($argv);
	}
}