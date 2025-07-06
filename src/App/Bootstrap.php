<?php

namespace Apex\Core\App;

use Apex\Core\Container\Container;

class Bootstrap
{
    public static function boot(array $config = []): Container
    {

        global $app;
        $app = new Application();

        $app->registerConfiguredProviders(self::getCoreConfig()['providers']);

        if (isset($config['providers']) && is_array($config['providers'])) {
            $app->registerConfiguredProviders($config['providers']);
        }

        return $app;
    }

    private static function getCoreConfig(): array
    {
        return require __DIR__ . "/../Config/app.php";
    }
}