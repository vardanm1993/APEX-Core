<?php

namespace Apex\Core\App;

use Apex\Core\Container\Container;
use Apex\Core\Repository\ConfigRepository;

class Application extends Container
{

    protected array $providers = [];
    protected array $loadedProviders = [];

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

    public function registerConfiguredProviders(): void
    {
        $config = $this->make(ConfigRepository::class);
        foreach ($config('app.providers',[]) as $providerClass) {
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