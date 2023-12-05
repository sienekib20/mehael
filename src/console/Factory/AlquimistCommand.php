<?php

namespace Sienekib\Mehael\Console\Factory;

class AlquimistCommand
{
	public function make()
	{

	}

	public function migrate()
	{

	}

	public function run($argv)
	{
		echo "\033[1;33mStarting server on http://127.0.0.1:8000\n\033[0m";
        echo "\033[0m";
		exec("php -S 127.0.0.1:8000 -t public");
        echo "\033[0m";
	}

	public function __()
	{

	}

}
