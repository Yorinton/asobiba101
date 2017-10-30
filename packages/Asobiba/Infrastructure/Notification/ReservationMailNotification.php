<?php

namespace Infrastructure\Notification;

use Asobiba\Domain\Models\Notification\ReservationNotification;
use Asobiba\Domain\Models\Reservation\Reservation;
use Mail;

class ReservationMailNotification implements ReservationNotification
{


    public function notifyToCustomer(Reservation $reservation): bool
    {
        // TODO: Implement notifyToCustomer() method.
        // メールの表題、本文の作成

        // メール送信

        //　メール送信成否のフラグを返す
        return true;
    }

    public function notifyToManager(Reservation $reservation): bool
    {
        // TODO: Implement notifyToManager() method.
        // メールの表題、本文の作成

        // メール送信

        //　メール送信成否のフラグを返す
        return true;
    }


}



?>