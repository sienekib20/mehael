<?php

namespace Sienekib\Mehael\Database\Factory;

use Sienekib\Mehael\Database\Concerns\Connection;
use Sienekib\Mehael\Database\Database;

class DB
{
	public static function __callStatic($method, $args)
	{
		$instance = new Database((new Connection())->getConnection());

		return call_user_func_array([$instance, $method], $args);
	}
}