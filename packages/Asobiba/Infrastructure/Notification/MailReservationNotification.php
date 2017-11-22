<?php

namespace Infrastructure\Notification;

use App\Mail\ToCustomerNotQuestion;
use Asobiba\Domain\Models\Notification\ReservationNotificationInterface;
use Asobiba\Domain\Models\Reservation\Reservation;
use Mail;

class MailReservationNotification implements ReservationNotificationInterface
{


    public function notifyToCustomer(Reservation $reservation): bool
    {
        $mailable = $reservation->getNotification()->getNotification();

        Mail::to($reservation->getCustomer()->getEmail())
            ->send(new $mailable($reservation->getCustomer(),$reservation));

        return true;
    }


    public function notifyToManager(Reservation $reservation): bool
    {
        // TODO: Implement notifyToManager() method.
        // メール送信


        //　メール送信成否のフラグを返す
        return true;
    }


}



?>