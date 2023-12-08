<?php

namespace Sienekib\Mehael\Bootstrap;

use PDO;
use Sienekib\Mehael\Database\Concerns\Connection;
use Sienekib\Mehael\Http\Request;
use Sienekib\Mehael\Http\Response;
use Sienekib\Mehael\Router\Anotation\Route;
use Sienekib\Mehael\Exceptions\Whoops;

class Application
{
	private Request $request;
	private Response $response;
	private Route $route;
	private Connection $connection;
	private $whoops = null;

	public function __construct()
	{
		$this->request = new Request();
		$this->response = new Response();
		$this->route = new Route($this->request, $this->response);
		$this->connection = new Connection();
		$this->whoops = Whoops::lookUp();
	}

	public function start()
	{
		try {
			$this->connection->initDBConnection();
			$this->route->dispatch();
		} catch (\Exception $e) {
			$this->whoops->handleException($e);
		}
	}
}
