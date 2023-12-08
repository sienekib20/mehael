<?php

namespace Sienekib\Mehael\Exceptions;

class Whoops
{
	public static function lookUp()
	{
		$whoops = new \Whoops\Run;
		$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		$whoops->register();
		return $whoops;
	}
}