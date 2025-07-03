<?php

namespace Apex\Core\Providers;

use Apex\Core\Http\Request;
use Apex\Core\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Request::class, fn() => Request::capture());
    }
}