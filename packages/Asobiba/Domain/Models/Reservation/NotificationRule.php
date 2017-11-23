<?php

namespace Asobiba\Domain\Models\Reservation;

class NotificationRule
{

    private $method;

    public function __construct(Reservation $reservation)
    {
        if (!$reservation->hasQuestion()) {
            $this->method = 'ToCustomerNotQuestion';
        } elseif ($reservation->hasQuestion()) {
            $this->method = 'ToCustomerWithQuestion';
        }
    }

    public function getNotifyMethod()
    {
        return $this->method;
    }
}