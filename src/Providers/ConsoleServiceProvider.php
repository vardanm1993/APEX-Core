<?php

namespace Apex\Core\Providers;

use Apex\Core\Console\Kernel;
use Apex\Core\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Kernel::class, function () {
            $kernel = new Kernel();

            foreach ($this->app->getConfig()['commands'] as $command) {
                $kernel->registerCommands(new $command);
            }

            return $kernel;
        });
    }
}