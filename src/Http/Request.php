<?php

namespace Apex\Core\Http;

readonly class Request
{
    public function __construct(
        private array   $get = [],
        private array   $post = [],
        private array   $server = [],
        private array   $cookies = [],
        private array   $files = [],
        private ?string $rawBody = null
    )
    {
    }

    public static function capture(): self
    {
        return new self(
            $_GET,
            $_POST,
            $_SERVER,
            $_COOKIE,
            $_FILES,
            file_get_contents('php://input')
        );
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        return parse_url($this->server['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    }

    public function input(string $key, $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    public function has(string $key): bool
    {
        return isset($this->post[$key]) || isset($this->get[$key]);
    }

    public function only(array $keys): array
    {
        return array_intersect_key($this->all(), array_flip($keys));
    }

    public function except(array $keys): array
    {
        return array_diff_key($this->all(), array_flip($keys));
    }


    public function cookie(string $key, mixed $default = null): mixed
    {
        return $this->cookies[$key] ?? $default;
    }

    public function header(string $key, mixed $default = null): mixed
    {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return $this->server[$key] ?? $default;
    }

    public function isJson(): bool
    {
        return str_contains($this->header('Content-Type', ''), 'application/json');
    }

    public function json(): array
    {
        if (!$this->isJson()) {
            return [];
        }

        $decoded = json_decode($this->rawBody ?? '', true);

        return is_array($decoded) ? $decoded : [];
    }

    public function file(string $key): mixed
    {
        return $this->files[$key] ?? null;
    }
}