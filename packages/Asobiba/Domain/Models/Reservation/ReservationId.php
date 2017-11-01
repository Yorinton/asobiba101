<?php

namespace Asobiba\Domain\Models\Reservation;


class ReservationId
{
    /** @var */
    private $id;

    public function __construct()
    {
        $this->id = uniqid('asobiba_',false);
    }

    public function getId(): string
    {
        return $this->id;
    }
}
