<?php

use Sienekib\Mehael\Bootstrap\Application;
use Sienekib\Mehael\Http\Response;
use Sienekib\Mehael\Support\Session;
use Sienekib\Mehael\Http\Request;
use Sienekib\Mehael\Http\Src\Redirect;
use Sienekib\Mehael\Template\View;

if (!function_exists('app')) :

	// A instância da classe Application

	function app(): Application
	{
		static $instance = null;
		if ($instance == null) {
			$instance = (new Application());
		}
		return $instance;
	}
endif;

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

if (!function_exists('view_path')) :
	function view_path()
	{
		return abs_path() . '/resources/views';
	}
endif;

if (!function_exists('storage_path')) :
	function storage_path()
	{
		return abs_path() . '/public/storage/';
	}
endif;

if (!function_exists('view')) :
	function view(string $view, array $params = [])
	{
		return View::render($view, $params);
	}
endif;

if (!function_exists('redirect')) :
	function redirect()
	{
		return (new Redirect());
	}
endif;

if (!function_exists('response')) :
	function response()
	{
		return (new Response());
	}
endif;

if (!function_exists('parts')) :

    function parts($part)
    {
        $parts = view_path() . "/parts/" . str_replace('.', '/', $part) . ".php";
        try {
            if (!file_exists($parts))
                throw new \Exception("Arquivo {$part} não encontrado", 1);
            include $parts;
        } catch (\Exception $ex) {
        	echo $ex->getMessage();
            response()->setStatusCode(404);
            exit;
        }
    }

endif;

if (!function_exists('asset_path')) :

    function asset_path()
    {
        return '/assets/';
    }

endif;


if (!function_exists('asset')) :

    function asset($asset)
    {
        $fileType = explode('/', $asset)[0];

        return asset_path() . $asset;
    }

endif;

if (!function_exists('request')) :

    function request()
    {
        return (new Request());
    }

endif;

if (!function_exists('session')) :

    function session()
    {
        return (new Session());
    }

endif;

if (!function_exists('route')) :

    function route(string $route, mixed $bind = null)
    {
    	if (str_contains($route, '.')) {
    		$route = str_replace('.', '/', $route);
    	}
    	return ($bind != null) ? "/$route/$bind" : "/$route";
    }

endif;
