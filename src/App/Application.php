<?php

namespace Apex\Core\App;

use Apex\Core\Container\Container;

class Application extends Container
{

    protected array $providers = [];
    protected array $loadedProviders = [];

    public function __construct(private readonly array $config)
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

    public function registerConfiguredProviders(): void
    {
        foreach ($this->config['providers'] as $providerClass) {
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

    public function getConfig(): array
    {
      return $this->config;
    }

}