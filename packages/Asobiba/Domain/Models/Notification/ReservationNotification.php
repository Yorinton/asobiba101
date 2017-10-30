<?php

namespace Asobiba\Domain\Models\Notification;

use Asobiba\Domain\Models\Reservation\Reservation;

interface ReservationNotification
{
    public function notifyToCustomer(Reservation $reservation);

    public function notifyToManager(Reservation $reservation);
}