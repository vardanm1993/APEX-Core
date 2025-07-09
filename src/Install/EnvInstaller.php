<?php

namespace Apex\Core\Install;

class EnvInstaller
{
    public static function copyEnvExample(): void
    {
        $source = core_path('.env');
        $target = getcwd() . '/.env';

        if (!file_exists($source)) {
            echo "⚠️  .env.example not found in core\n";
            return;
        }

        if (file_exists($target)) {
            echo "🟡 .env already exists in project, skipping copy\n";
            return;
        }

        if (!copy($source, $target)) {
            echo "❌ Failed to copy .env.example to .env\n";
        } else {
            echo "✅ Copied .env.example to .env\n";
        }
    }
}
