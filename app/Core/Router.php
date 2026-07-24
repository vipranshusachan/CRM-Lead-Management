<?php

declare(strict_types=1);

namespace App\Core;

use Exception;

class Router
{
    private Request $request;
    private array $routes = [];
    private array $groupMiddleware = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get(string $path, array $handler, array $middleware = []): self
    {
        return $this->addRoute('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array $handler, array $middleware = []): self
    {
        return $this->addRoute('POST', $path, $handler, $middleware);
    }

    public function put(string $path, array $handler, array $middleware = []): self
    {
        return $this->addRoute('PUT', $path, $handler, $middleware);
    }

    public function delete(string $path, array $handler, array $middleware = []): self
    {
        return $this->addRoute('DELETE', $path, $handler, $middleware);
    }

    public function group(array $attributes, callable $callback): void
    {
        $previousGroupMiddleware = $this->groupMiddleware;
        
        if (isset($attributes['middleware'])) {
            $this->groupMiddleware = array_merge($this->groupMiddleware, (array) $attributes['middleware']);
        }

        $callback($this);

        $this->groupMiddleware = $previousGroupMiddleware;
    }

    private function addRoute(string $method, string $path, array $handler, array $middleware = []): self
    {
        $allMiddleware = array_merge($this->groupMiddleware, $middleware);
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => '/' . trim($path, '/'),
            'handler' => $handler,
            'middleware' => $allMiddleware
        ];
        return $this;
    }

    public function dispatch(): void
    {
        $requestMethod = $this->request->getMethod();
        $requestUri = '/' . trim($this->request->getUri(), '/');
        if ($requestUri !== '/' && str_ends_with($requestUri, '/')) {
            $requestUri = rtrim($requestUri, '/');
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $requestUri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Run Middleware Pipeline
                foreach ($route['middleware'] as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    $middleware->handle($this->request);
                }

                [$controllerClass, $method] = $route['handler'];
                $controller = new $controllerClass();

                // Call Controller method with request and parameters
                call_user_func_array([$controller, $method], array_merge([$this->request], $params));
                return;
            }
        }

        // 404 Not Found
        if ($this->request->isJson()) {
            json_response(['success' => false, 'error' => 'Route not found'], 404);
        } else {
            http_response_code(404);
            if (file_exists(BASE_PATH . '/views/errors/404.php')) {
                view('errors.404');
            } else {
                echo "<h1>404 Not Found</h1>";
            }
        }
    }
}
