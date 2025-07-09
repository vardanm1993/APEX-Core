<?php

namespace Apex\Core\Providers;

use Apex\Core\Repository\EnvRepository;
use Apex\Core\Support\ServiceProvider;
use Dotenv\Dotenv;

class EnvServiceProvider extends ServiceProvider
{
    public  function register(): void
    {
        $envPath = file_exists(base_path('.env'))
            ? base_path()
            : core_path();

        if (file_exists($envPath . '/.env')) {
            Dotenv::createImmutable($envPath)->safeLoad();
        }

        $this->app->singleton(EnvRepository::class, fn () => new EnvRepository());
    }
}