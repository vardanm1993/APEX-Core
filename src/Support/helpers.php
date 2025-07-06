<?php


use Apex\Core\Container\Container;

if (!function_exists('app')) {
    function app(): Container
    {
        global $app;
        return $app;
    }
}