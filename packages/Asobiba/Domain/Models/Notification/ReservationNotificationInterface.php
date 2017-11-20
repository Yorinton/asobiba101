<?php

namespace Asobiba\Domain\Models\Notification;

use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\User\Customer;

interface ReservationNotificationInterface
{
    function notifyToCustomer(Customer $customer,Reservation $reservation);

    function notifyToManager(Customer $customer,Reservation $reservation);

}