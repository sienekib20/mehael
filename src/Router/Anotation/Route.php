<?php

namespace Sienekib\Mehael\Router\Anotation;

use Sienekib\Mehael\Http\Request;
use Sienekib\Mehael\Http\Response;
use Sienekib\Mehael\Router\AbstractRoute;
use Sienekib\Mehael\Router\Src\Wildcards;

class Route extends AbstractRoute
{
	/**
	 * Todas as rotas do app
	 * @var array
	 */
	private static array $routes = [];

	/**
	 * Middleware de agrupamento
	 * @var string
	 */
	private static ?string $middleware = null;

	/**
	 * Prefixo de rotas agrupadas
	 * @var string
	 */
	private static ?string $prefix = null;

	/**
	 * Parâmetros da requisição
	 * @var array
	 */
	private static array $parameters = [];

	/**
	 * Patterna de regex da uri
	 * @var string
	 */
	private static string $pattern;

	/**
	 * Objeto request
	 * @var Request
	 */
	private static Request $request;

	/**
	 * Objeto response
	 * @var Response
	 */
	private static Response $response;

	/**
	 * Constructor de inicialização da classe Route
	 */
	public function __construct(Request $request, Response $response)
	{
		static::$request = $request;
		static::$response = $response;
	}

	/**
	 * Regista as rotas no array
	 */
	public static function add(string $method, string $uri, callable|array $action)
	{
		static::$routes[] = (object) [
			'method' => $method,
			'uri' => $uri,
			'action' => $action,
			'prefix' => static::$prefix,
			'middleware' => static::$middleware
		];
	}
	/**
	 * Define um prefixo às rotas
	 * @return Route
	 */
	public static function prefix(string $prefix): Route
	{
		static::$prefix = $prefix;

		return new static(new Request, new Response);
	}

	/**
	 * Define um agrupamento de rotas
	 * atribuindo-as um middleware
	 */
	public static function group(string $middleware, callable $callback)
	{
		static::$middleware = $middleware;

		// Verifica se é uma funcao 
		if (is_callable($callback)) {
			$callback();
		}

		static::$middleware = static::$prefix = null;
	}

	/**
	 * Patterna de regex da uri
	 */
	public function dispatch()
	{
		$found = false;

		foreach (static::$routes as $index => $route) {
			$route->uri = ($route->prefix) ? "/$route->prefix$route->uri" : $route->uri;
			$buildedPath = $this->buildPathUri($route->uri);
			$uri = $buildedPath->uri;
			$parameters = $buildedPath->params;


			if (preg_match("/^$uri$/", static::$request->uri(), $matches)) {
				$matches = array_slice($matches, 1);
				$parameters = $this->routeParameters($parameters, $matches);

				if (static::$request->method() == $route->method) {
					unset($route->method, $route->uri, $route->prefix);
					static::$request->bind($parameters);
					return $this->dispatchRoute($route, static::$request, static::$response);
				}

				echo 'Método de acesso não compatível';
				exit;
			}
		}

		echo 'Rota `'. static::$request->uri() .'` não encontrada';
		static::$response->setStatusCode(404);
		exit;
	}
}
