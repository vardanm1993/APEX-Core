<?php

namespace Apex\Core\Providers;

use Apex\Core\Repository\ConfigRepository;
use Apex\Core\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ConfigRepository::class, function () {

            $configPaths = [
                "core" => core_path("Config"),
            ];

            $appConfigPath = base_path("config");

            if (is_dir($appConfigPath)) {
                $configPaths["app"] = $appConfigPath;
            }


            $config = new ConfigRepository();

            return $config->load($configPaths);
        });

    }
}