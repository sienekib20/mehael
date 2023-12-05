<?php

namespace Sienekib\Mehael\Console\Factory;

use Sienekib\Mehael\Console\Printer;

class AlquimistCommand
{
    // the printer object
    private Printer $printer;

    Public function __construct()
    {
        $this->printer = new Printer();
    }

	public function make()
	{

	}

	public function migrate()
	{

	}

	public function run($argv)
	{
        $host = "127.0.0.1:8000";

        if (count($argv) > 1) {

            if (($runOption = explode(':', $argv[1])[1]) !== 'server')
                $this->printer::withError("Command : `".$runOption."`, not found. Try `run:server`")->die();

            if (! str_contains(($options = $argv[2]), '='))
                $this->printer::withError("Option: `".$options."`, not found. Try `--host=127.0.0.1:port`")->die();
            $options = explode('=', $options);

            if ($options[0] !== '--host')
                $this->printer::withError("Invalid option: `".$options[0]."`, try `--host`")->die();

            $host = $options[1];
        }

		echo "\033[1;36mStarting server on http://{$host}\n\033[0m";
        echo "\033[0m";
		exec("php -S $host -t public");
        echo "\033[0m";
	}

	public function __()
	{

	}

}
