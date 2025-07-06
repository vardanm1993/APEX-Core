<?php

namespace Apex\Core\Exception;
class Handler
{
    public function handle(\Throwable $e): void
    {
        error_log($e->getMessage());

        http_response_code(500);

        echo "An internal server error occurred.";
    }
}
