<?php

namespace Apex\Core\App;

use Apex\Core\Container\Container;
use Apex\Core\Providers\ConfigServiceProvider;
use Apex\Core\Providers\EnvServiceProvider;
use Dotenv\Dotenv;

class Bootstrap
{
    public static function boot(): Container
    {
        self::loadEnv();

        global $app;
        $app = new Application();

        $app->registerProvider(EnvServiceProvider::class);
        $app->registerProvider(ConfigServiceProvider::class);

        $app->registerConfiguredProviders();

        return $app;
    }

    private static function loadEnv(): void
    {
        $envPath = file_exists(base_path('.env')) ? base_path() : core_path();

        if (file_exists($envPath . '/.env')) {
            Dotenv::createImmutable($envPath)->safeLoad();
        }
    }
}