<?php
namespace Apex\Core\Wave\Commands;

use Apex\Core\Console\Command;

class UpCommand extends Command
{
    protected string $name = 'up';
    protected string $description = 'Start the development environment';

    public function handle(array $args): int
    {
        $projectCompose = getcwd() . '/docker-compose.yml';
        $coreCompose = __DIR__ . '/../Docker/docker-compose.yml';

        $composeFile = file_exists($projectCompose) ? $projectCompose : $coreCompose;

        echo "Using docker-compose file: {$composeFile}\n";

        passthru("docker compose -f {$composeFile} up -d");

        return 0;
    }
}
