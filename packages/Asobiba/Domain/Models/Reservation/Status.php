<?php

namespace Asobiba\Domain\Models\Reservation;


final class Status
{
    const ENUM = [
        'Contact' => 'Contact',
        'Confirmation' => 'Confirmation',
        'BeforePayment' => 'BeforePayment',
        'AfterPayment' => 'AfterPayment',
        'BeforeUse' => 'BeforeUse',
        'Used' => 'Used',
    ];

    private $status;

    public function __construct($key)
    {
        if (!static::isValidValue($key)) {
            throw new \InvalidArgumentException;
        }

        $this->status = self::ENUM[$key];
    }

    public static function isValidValue($key)
    {
        return array_key_exists($key, self::ENUM);
    }

    public function __toString()
    {
        return $this->status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public static function __callStatic($method, array $args)
    {
        return new self($method);
    }

    public function __set($key, $value)
    {
        throw new \BadMethodCallException('All setter is forbbiden');
    }

    public function toConfirmation()
    {
        if($this->status !== 'Contact'){
            throw new \InvalidArgumentException('このステータスには変更出来ません');
        }
        return new self('Confirmation');
    }
}


?>