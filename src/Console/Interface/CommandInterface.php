<?php

namespace Apex\Core\Console\Interface;

interface CommandInterface
{
    public function getName(): string;
    public function getDescription(): string;
    public function handle(array $args): int;
}