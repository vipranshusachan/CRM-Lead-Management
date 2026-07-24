<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    private string $uri;
    private string $method;
    private array $params;
    private array $headers;
    private array $body;

    public function __construct()
    {
        $this->uri = $this->parseUri();
        $this->method = strtoupper($_POST['_method'] ?? $_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->headers = $this->parseHeaders();
        $this->body = $this->parseBody();
        $this->params = $_GET;
    }

    private function parseUri(): string
    {
        $rawUri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Strip query string
        if (($pos = strpos($rawUri, '?')) !== false) {
            $rawUri = substr($rawUri, 0, $pos);
        }

        $rawUri = urldecode($rawUri);

        // Normalize base path from SCRIPT_NAME
        $scriptName = urldecode($_SERVER['SCRIPT_NAME'] ?? '');
        $baseFolder = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

        // If baseFolder contains /public, get root parent as well
        $parentFolder = '';
        if (str_ends_with($baseFolder, '/public')) {
            $parentFolder = substr($baseFolder, 0, -7);
        }

        if ($baseFolder !== '' && $baseFolder !== '/' && str_starts_with($rawUri, $baseFolder)) {
            $rawUri = substr($rawUri, strlen($baseFolder));
        } elseif ($parentFolder !== '' && str_starts_with($rawUri, $parentFolder)) {
            $rawUri = substr($rawUri, strlen($parentFolder));
        }

        // Strip /public if URL contains /public prefix
        if (str_starts_with($rawUri, '/public')) {
            $rawUri = substr($rawUri, 7);
        }

        $uri = '/' . trim($rawUri, '/');
        return $uri === '' ? '/' : $uri;
    }

    private function parseHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $headerKey = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $headers[$headerKey] = $value;
            }
        }
        if (isset($_SERVER['CONTENT_TYPE'])) {
            $headers['Content-Type'] = $_SERVER['CONTENT_TYPE'];
        }
        return $headers;
    }

    private function parseBody(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (str_contains($contentType, 'application/json')) {
            $rawInput = file_get_contents('php://input');
            $decoded = json_decode($rawInput, true);
            return is_array($decoded) ? $decoded : [];
        }

        if ($this->method === 'PUT' || $this->method === 'PATCH' || $this->method === 'DELETE') {
            $rawInput = file_get_contents('php://input');
            parse_str($rawInput, $data);
            return is_array($data) ? array_merge($_POST, $data) : $_POST;
        }

        return $_POST;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name, ?string $default = null): ?string
    {
        foreach ($this->headers as $key => $value) {
            if (strcasecmp($key, $name) === 0) {
                return $value;
            }
        }
        return $default;
    }

    public function input(?string $key = null, mixed $default = null): mixed
    {
        $all = array_merge($this->params, $this->body);
        if ($key === null) {
            return $all;
        }
        return $all[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->params, $this->body);
    }

    public function isJson(): bool
    {
        return str_contains($this->getHeader('Content-Type', ''), 'application/json') ||
               str_contains($this->getHeader('Accept', ''), 'application/json');
    }
}
