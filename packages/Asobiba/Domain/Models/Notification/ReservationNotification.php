<?php

namespace Asobiba\Domain\Models\Notification;

use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\User\Customer;

interface ReservationNotification
{
    public function notifyToCustomer(Customer $customer,Reservation $reservation);

    public function notifyToManager(Customer $customer,Reservation $reservation);

    protected function createBodyToCustomer(Customer $customer,Reservation $reservation);

    protected function createBodyToManager(Customer $customer,Reservation $reservation);
}