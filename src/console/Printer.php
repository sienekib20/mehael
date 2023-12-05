<?php

namespace Sienekib\Mehael\Console;

class Printer
{
	public static function withError(string $text)
	{
		echo "\033[0;33m$text\033[0m";

		return new static();
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