<?php

namespace Asobiba\Domain\Models\Reservation;

use Asobiba\Domain\Models\Enum;

final class Status extends Enum
{
    protected const ENUM = [
        'Contact' => 'Contact',
        'Confirmation' => 'Confirmation',
        'BeforePayment' => 'BeforePayment',
        'AfterPayment' => 'AfterPayment',
        'BeforeUse' => 'BeforeUse',
        'Used' => 'Used',
        'Canceled' => 'Canceled',
    ];


    public function toConfirmation()
    {
        if($this->value !== 'Contact'){
            throw new \InvalidArgumentException('このステータスには変更出来ません');
        }
        return new self('Confirmation');
    }

    public function toBeforePayment()
    {
        if($this->value !== 'Confirmation'){
            throw new \InvalidArgumentException('このステータスには変更出来ません');
        }
        return new self('BeforePayment');
    }

    public function toAfterPayment()
    {
        if($this->value !== 'BeforePayment'){
            throw new \InvalidArgumentException('このステータスには変更出来ません');
        }
        return new self('AfterPayment');
    }

    public function toBeforeUse()
    {
        if($this->value !== 'AfterPayment'){
            throw new \InvalidArgumentException('このステータスには変更出来ません');
        }
        return new self('BeforeUse');
    }

    public function toUsed()
    {
        if($this->value !== 'BeforeUse'){
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