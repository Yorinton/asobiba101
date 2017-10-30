<?php

namespace Asobiba\Domain\Models\Repositories\Reservation;

use Asobiba\Domain\Models\Reservation\Reservation;

interface ReservationRepositoryInterface
{
    public function add(Reservation $reservation);
}


?>