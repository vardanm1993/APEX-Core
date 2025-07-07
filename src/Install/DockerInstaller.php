<?php

namespace Apex\Core\Install;

class DockerInstaller
{
    public static function compyDockerCompose(): void
    {
        $source = __DIR__ . "/../Wave/Docker/docker-compose.yml";
        $target = getcwd() . '/docker-compose.yml';

        if (!file_exists($source)) {
            echo "⚠️  docker-compose.yml not found in core\n";
            return;
        }

        if (file_exists($target)) {
            echo "🟡 docker-compose.yml already exists in project, skipping copy\n";
            return;
        }

        if (!copy($source, $target)) {
            echo "❌ Failed to copy docker-compose.yml\n";
        } else {
            echo "✅ Copied docker-compose.yml to project root\n";
        }
    }
}