<?php

namespace Apex\Core\App;

use Apex\Core\Container\Container;

class Bootstrap
{
    public static function boot(array $config = []): Container
    {

        $config = array_merge_recursive(self::getCoreConfig(),$config);

        global $app;
        $app = new Application($config);

        $app->registerConfiguredProviders();

        return $app;
    }

    private static function getCoreConfig(): array
    {
        return require __DIR__ . "/../Config/app.php";
    }
}