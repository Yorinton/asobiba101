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
        'Canceled' => 'Canceled',
    ];

    private $status;

    public function __construct($key)
    {
        if (!static::isValidValue($key)) {
            throw new \InvalidArgumentException('定義されていないステータス');
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

    public function toBeforePayment()
    {
        if($this->status !== 'Confirmation'){
            throw new \InvalidArgumentException('このステータスには変更出来ません');
        }
        return new self('BeforePayment');
    }

    public function toAfterPayment()
    {
        if($this->status !== 'BeforePayment'){
            throw new \InvalidArgumentException('このステータスには変更出来ません');
        }
        return new self('AfterPayment');
    }

    public function toBeforeUse()
    {
        if($this->status !== 'AfterPayment'){
            throw new \InvalidArgumentException('このステータスには変更出来ません');
        }
        return new self('BeforeUse');
    }

    public function toUsed()
    {
        if($this->status !== 'BeforeUse'){
            throw new \InvalidArgumentException('このステータスには変更出来ません');
        }
        return new self('Used');
    }

    public function toCanceled()
    {
        return new self('Canceled');
    }

}


?>