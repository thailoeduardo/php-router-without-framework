<?php
namespace App;

class Router
{
	private array $routes = [];

	public function get(string $path, callable | array $callback): void
	{
		$this->routes['GET'][$path] = $callback;
	}

	public function post(string $path, callable | array $callback): void
	{
		$this->routes['POST'][$path] = $callback;
	}

	public function resolve(): mixed
	{
			$method = $_SERVER['REQUEST_METHOD'];
			$path   = $_SERVER['REQUEST_URI'] ?? '/';
			$path   = explode('?', $path)[0];
	
			foreach ($this->routes[$method] ?? [] as $route => $callback) {
					$pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[^/]+)', $route);
					$pattern = '#^' . $pattern . '$#';
	
					if (preg_match($pattern, $path, $matches)) {
							$params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY); // Pegamos apenas os valores nomeados
	
							if (is_array($callback)) {
									[$class, $method] = $callback;
									$controller = new $class();
									return call_user_func_array([$controller, $method], $params);
							}
	
							return call_user_func_array($callback, $params);
					}
			}
	
			http_response_code(404);
			return "404 Not Found";
	}
	
}
