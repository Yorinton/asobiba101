<?php

namespace Asobiba\Domain\Models;

class Enum
{
    protected const ENUM = [];

    protected $value;

    public function __construct($key)
    {
        if (!static::isValidValue($key)) {
            throw new \InvalidArgumentException('定義されていない値');
        }

        $this->value = static::ENUM[$key];
    }

    public static function isValidValue($key)
    {
        return array_key_exists($key, static::ENUM);
    }

    public function __toString()
    {
        return $this->value;
    }

    public static function __callStatic($method, array $args)
    {
        return new self($method);
    }

    public function __set($key, $value)
    {
        throw new \BadMethodCallException('All setter is forbbiden');
    }
}





?>