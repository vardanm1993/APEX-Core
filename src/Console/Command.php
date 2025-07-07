<?php

namespace Apex\Core\Console;

use Apex\Core\Console\Interface\CommandInterface;

abstract class Command implements CommandInterface
{

    protected string $name = '';
    protected string $description = '';
    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function handle(array $args): int
    {
        return 0;
    }
}