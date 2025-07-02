<?php

namespace Apex\Core\Support;
use Apex\Core\Container\Container;

abstract class ServiceProvider
{

    public function __construct(protected Container $app)
    {

    }

    public function register(): void {}
    public function boot(): void {}
}