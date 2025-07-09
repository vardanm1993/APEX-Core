<?php

namespace Apex\Core\Repository;

class ConfigRepository
{
    protected array $items = [];

    public function load(array $configPaths): ConfigRepository
    {
        $appPath = $configPaths["app"] ?? null;
        $corePath = $configPaths["core"];

        $this->getConfigFromPath($corePath);

        if ($appPath && is_dir($appPath)) {
            $this->getConfigFromPath($appPath);
        }

        return $this;
    }

    private function getConfigFromPath(string $path): void
    {
        foreach (glob($path . '/*.php') as $file) {
            $key = basename($file, '.php');
            $config = require $file;

            if (isset($this->items[$key]) && is_array($this->items[$key]) && is_array($config)) {
                $this->items[$key] = $this->mergeConfig($this->items[$key], $config);
            } else {
                $this->items[$key] = $config;
            }
        }
    }

    private function mergeConfig(array $base, array $override): array
    {
        foreach ($override as $key => $value) {
            if (isset($base[$key]) && is_array($base[$key]) && is_array($value)) {
                $base[$key] = $this->mergeConfig($base[$key], $value);
            } else {
                $base[$key] = $value;
            }
        }

        return $base;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $items = $this->items;

        foreach ($keys as $key) {
            if (is_array($items) && array_key_exists($key, $items)) {
                $items = $items[$key];
            } else {
                return $default;
            }
        }

        return $items;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function has(string $key): bool
    {
        return $this->get($key, '__not_found__') !== '__not_found__';
    }

    public function set(string $key, mixed $value): void
    {
        $keys = explode('.', $key);
        $ref = &$this->items;

        foreach ($keys as $k) {
            if (!isset($ref[$k]) || !is_array($ref[$k])) {
                $ref[$k] = [];
            }
            $ref = &$ref[$k];
        }

        $ref = $value;
    }

}
