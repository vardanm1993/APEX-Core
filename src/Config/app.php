<?php

use Apex\Core\Console\Commands\HelloCommand;
use Apex\Core\Providers\ConsoleServiceProvider;
use Apex\Core\Providers\HttpServiceProvider;
use Apex\Core\Wave\Commands\DownCommand;
use Apex\Core\Wave\Commands\UpCommand;

return [
    'providers' =>  [
        HttpServiceProvider::class,
        ConsoleServiceProvider::class,
    ],

    'commands' =>  [

        HelloCommand::class,

        //wave
        UpCommand::class,
        DownCommand::class,
    ]
];