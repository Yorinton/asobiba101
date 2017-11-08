<?php

namespace Asobiba\Domain\Models\Reservation;


class ReservationId
{
    /** @var */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
