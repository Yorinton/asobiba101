<?php

namespace Asobiba\Domain\Models\Reservation;

class NotificationRule
{


    public function getNotification(Reservation $reservation)
    {
        if(!$reservation->hasQuestion()){
            return 'ToCustomerNotQuestion';
        }
        if($reservation->hasQuestion()){
            return 'ToCustomerWithQuestion';
        }

    }
}