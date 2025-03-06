<?php
namespace App;

class Router
{
	private $router = [];

	public function get( string $patch, callable|array $callback): void
	{
		$this->router['GET'][$patch] = $callback;
	}
	
	public function post( string $patch, callable|array $callback): void
	{
		$this->router['POST'][$patch] = $callback;
	}

	public function resolve(): mixed
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$path = explode('?', $path)[0];
		
		$callback = $this->routes[$method][$path] ?? null;
		
		if ($callback === null) {
			http_response_code(404);
			return "404 Not Found";
		}
		
		if (is_array($callback)) {
			[$class, $method] = $callback;
			$controller = new $class();
			
			return $controller->$method();
		}
		
		return $callback();
	}
}