<?php


use Apex\Core\App\Application;
use Apex\Core\Container\Container;
use Apex\Core\Repository\ConfigRepository;
use Apex\Core\Repository\EnvRepository;

if (!function_exists('app')) {
    function app(): Container
    {
        global $app;
        return $app;
    }
}


if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        $cwd = getcwd();

        if (basename($cwd) === 'public') {
            $base = dirname($cwd);
        } else {
            $base = $cwd;
        }

        return $base . ($path ? '/' . ltrim($path, '/') : '');
    }
}

if (!function_exists('core_path')) {
    function core_path(string $path = ''): string
    {
        static $coreSrcPath;

        if (!$coreSrcPath) {
            $reflection = new ReflectionClass(Application::class);
            $coreSrcPath = dirname($reflection->getFileName(), 2);
        }

        return rtrim($coreSrcPath, '/') . ($path ? '/' . ltrim($path, '/') : '');
    }
}

if (!function_exists('config')) {
    function config(?string $key = null, mixed $default = null)
    {
        $config = app()->make(ConfigRepository::class);

        if (is_null($key)) {
            return $config->all();
        }

        return $config->get($key, $default);
    }
}

if (!function_exists('env')) {
    function env(?string $key = null, mixed $default = null): mixed
    {
        $env = app()->make(EnvRepository::class);

        return $env->get($key, $default);
    }
}