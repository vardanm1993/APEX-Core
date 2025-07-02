<?php

require __DIR__ . '/vendor/autoload.php';

use Apex\Core\Http\Request;

$request = Request::capture();


echo "Method: " . $request->method() . "\n";
echo "URI: " . $request->uri() . "\n";