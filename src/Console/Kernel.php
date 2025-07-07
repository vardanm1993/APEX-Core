<?php

namespace Apex\Core\Console;

use Apex\Core\Console\Interface\CommandInterface;

class Kernel
{
    protected array $commands = [];

    public function registerCommands(CommandInterface $command): void
    {
        $this->commands[$command->getName()] = $command;
    }

    public function handle(array $argv): int
    {
        $name = $argv[1] ?? 'help';
        $args = array_slice($argv, 2);

        if (!isset($this->commands[$name])) {
            echo "Command not found: {$name}\n";
            return 1;
        }

        return $this->commands[$name]->handle($args);
    }

    public function list(): void
    {
        echo "Available commands:\n\n";
        foreach ($this->commands as $command) {
            echo "  " . $command->getName() . "\t" . $command->getDescription() . "\n";
        }
    }
}