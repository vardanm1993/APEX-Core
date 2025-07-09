<?php

namespace Apex\Core\Providers;

use Apex\Core\Repository\EnvRepository;
use Apex\Core\Support\ServiceProvider;
use Dotenv\Dotenv;

class EnvServiceProvider extends ServiceProvider
{
    public  function register(): void
    {
        $this->app->singleton(EnvRepository::class, fn () => new EnvRepository());
    }
}