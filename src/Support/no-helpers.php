<?php

use Sienekib\Mehael\Http\Response;

if (!function_exists('abs_path')) :
	function abs_path()
	{
		return dirname(__DIR__, 2);
	}
endif;

if (!function_exists('env')) :
	function env(string $key, $default = null)
	{
		return $_ENV[$key] ?? $default;
	}
endif;

if (!function_exists('response')) :
	function response()
	{
		return (new Response());
	}
endif;
