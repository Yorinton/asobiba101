<?php

namespace Asobiba\Domain\Models\Notification;

use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\User\Customer;

interface ReservationNotificationInterface
{
    function notifyToCustomer(Reservation $reservation);

    function notifyToManager(Reservation $reservation);

}