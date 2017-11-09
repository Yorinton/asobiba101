<?php

namespace Asobiba\Domain\Models\Notification;

use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\User\Customer;

interface ReservationNotification
{
    function notifyToCustomer(Customer $customer,Reservation $reservation);

    function notifyToManager(Customer $customer,Reservation $reservation);

    function createBodyToCustomer(Customer $customer,Reservation $reservation);

    function createBodyToManager(Customer $customer,Reservation $reservation);
}