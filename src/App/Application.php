<?php

namespace Apex\Core\App;

use Apex\Core\Container\Container;

class Application extends Container
{
    protected array $providers = [];
    protected array $loadedProviders = [];

    public function __construct()
    {

    }

    public function registerProvider(string $providerClass): void
    {
        if (isset($this->loadedProviders[$providerClass])) {
            return;
        }

        $provider = new $providerClass($this);

        $provider->register();

        $this->providers[] = $provider;
        $this->loadedProviders[$providerClass] = true;

        if(method_exists($provider, 'boot')) {
            $provider->boot();
        }
    }

    public function registerConfiguredProviders(array $providers): void
    {
        foreach ($providers as $providerClass) {
            $this->registerProvider($providerClass);
        }
    }

    public function getLoadedProviders(): array
    {
        return $this->loadedProviders;
    }

    public function getRegisteredProviders(): array
    {
        return $this->providers;
    }
}