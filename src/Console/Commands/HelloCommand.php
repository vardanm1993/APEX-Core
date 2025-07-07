<?php

namespace Apex\Core\Console\Commands;

use Apex\Core\Console\Command;

class HelloCommand extends Command
{
    protected string $name = 'say:hello';

    protected string $description = 'Says Hello World';


    public function handle(array $args): int
    {
        echo "👋 Hello, Apex World!\n";
        return 0;
    }
}