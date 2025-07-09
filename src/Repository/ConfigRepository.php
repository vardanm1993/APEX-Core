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

       if ($appPath and is_dir($appPath)) {
           $this->getConfigFromPath($appPath);
       }

        return $this;
    }

    private function getConfigFromPath(string $path): void
    {
        foreach (glob($path . '/*.php') as $file) {
            $key = basename($file, '.php');
            $this->items[$key] = require $file;
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $items = $this->items;

        foreach ($keys as $key) {
            if (is_array($items) && array_key_exists($key, $items)) {
                $items = $items[$key];
            }else {
                return $default;
            }
        }

        return $items;
    }

    public function all(): array
    {
        return $this->items;
    }

}