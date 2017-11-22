<?php

namespace Asobiba\Domain\Models\Repositories\Reservation;

use Asobiba\Domain\Models\Reservation\Reservation;


interface ReservationRepositoryInterface
{
    public function nextIdentity();

    public function new(array $req);

    public function persist(Reservation $reservation);
}
