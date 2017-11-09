<?php

namespace Asobiba\Domain\Models\Repositories\Reservation;

use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\User\Customer;

interface ReservationRepositoryInterface
{
    public function add(Customer $customer,Reservation $reservation);

    public function nextIdentity();
}


?>