<?php
use Apex\Core\App\Bootstrap;
use Apex\Core\Exception\Handler;
use Apex\Core\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

$app = Bootstrap::boot();

try {
    $request = $app->make(Request::class);

    echo "Method: " . $request->method() . PHP_EOL;
    echo "URI: " . $request->uri() . PHP_EOL;
} catch (Throwable $e) {
    (new Handler())->handle($e);
}
