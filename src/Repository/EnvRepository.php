<?php

namespace Apex\Core\Repository;

class EnvRepository
{
    public function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $_ENV)) {
            $result = $_ENV[$key];
        } else {
            $result = getenv($key);
        }

        if ($result === false || $result === null) {
            return $default;
        }

        return $this->castResult($result);
    }

    private function castResult(mixed $result): mixed
    {
        if (!is_string($result)) {
            return $result;
        }

        return $this->castLiteral(strtolower(trim($result)));
    }

    private function castLiteral(string $result): mixed
    {
        return match ($result) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'null', '(null)' => null,
            'empty', '(empty)' => '',
            default => $this->castNumber($result),
        };
    }


    private function castNumber(string $result): int
    {
        if (is_numeric($result)) {
            return $result + 0;
        }

        return $result;
    }
}