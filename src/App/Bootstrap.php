<?php

namespace Apex\Core\App;

use Apex\Core\Container\Container;
class Bootstrap
{
    public static function boot(): Container
    {
        $config = (!empty(self::getBaseConfig()))
            ? array_merge_recursive(self::getCoreConfig(), self::getBaseConfig())
            : self::getCoreConfig();

        global $app;
        $app = new Application($config);

        $app->registerConfiguredProviders();

        return $app;
    }

    private static function getBaseConfig(): array
    {
        if (!file_exists(base_path('config/app.php'))) {
            return [];
        }

        return require base_path('config/app.php');
    }

    private static function getCoreConfig(): array
    {
        return require core_path('Config/app.php');
    }
}