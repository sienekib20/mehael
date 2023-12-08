<?php

namespace Sienekib\Mehael\Console;

class Printer
{
	public function withError(string $text)
	{
		echo "\033[0;33m$text\033[0m";

		return $this;
	}

	public function outHelp()
	{
		echo " Alquimist " . $this->colorThisText("v1.0", "\033[0;33m").PHP_EOL.PHP_EOL;
		echo $this->colorThisText(" Usage:", "\033[0;33m") . PHP_EOL;
		echo "  command [options] [arguments]".PHP_EOL.PHP_EOL;

		echo $this->colorThisText(" db", "\033[0;33m").PHP_EOL;
		echo $this->colorThisText("  db:seed", "\033[0;32m") . "\t\tInsert default records in database".PHP_EOL;
		echo $this->colorThisText("  db:reset", "\033[0;32m") . "\t\tDrop all the tables".PHP_EOL;

		echo $this->colorThisText(" key", "\033[0;33m").PHP_EOL;
		echo $this->colorThisText("  key:generate", "\033[0;32m") . "\t\tSet the application key".PHP_EOL;

		echo $this->colorThisText(" make", "\033[0;33m").PHP_EOL;
		echo $this->colorThisText("  make:class", "\033[0;32m") . "\t\tCreate a new class".PHP_EOL;
		echo $this->colorThisText("  make:model", "\033[0;32m") . "\t\tCreate a new model".PHP_EOL;
		echo $this->colorThisText("  make:controller", "\033[0;32m") . "\tCreate a new controller".PHP_EOL;
		echo $this->colorThisText("  make:migration", "\033[0;32m") . "\tCreate a new migration file".PHP_EOL;
		echo $this->colorThisText("  make:seeder", "\033[0;32m") . "\t\tCreate a new seeder class".PHP_EOL;
		echo $this->colorThisText("  make:middleware", "\033[0;32m") . "\tCreate a new middleware class".PHP_EOL;

		echo $this->colorThisText(" migrate", "\033[0;33m").PHP_EOL;
		echo $this->colorThisText("  migrate:fresh", "\033[0;32m") . "\t\tRefresh all the tables".PHP_EOL;
		echo $this->colorThisText("  migrate:reset", "\033[0;32m") . "\t\tDrop all the tables".PHP_EOL;


		return $this;
	} 


	private function colorThisText(string $text, string $color_code)
	{
		return $color_code.$text."\033[0m";
	}

	public function exit()
	{
		exit;
	}

	public function die()
	{
		die();
	}
}