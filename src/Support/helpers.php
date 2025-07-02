<?php


use Apex\Core\Container\Container;

if (!function_exists('app')) {
    function app(): Container
    {
        return $GLOBALS['app'];
    }
}