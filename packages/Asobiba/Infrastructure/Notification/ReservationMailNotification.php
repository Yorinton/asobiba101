<?php

namespace Infrastructure\Notification;

use Asobiba\Domain\Models\Notification\ReservationNotification;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\User\Customer;
use Mail;

class ReservationMailNotification implements ReservationNotification
{


    public function notifyToCustomer(Customer $customer,Reservation $reservation): bool
    {
        // TODO: Implement notifyToCustomer() method.
        // メールの表題、本文の作成
        $content = $this->createBodyToCustomer($customer,$reservation);
        // メール送信

        //　メール送信成否のフラグを返す
        return true;
    }


    public function notifyToManager(Customer $customer,Reservation $reservation): bool
    {
        // TODO: Implement notifyToManager() method.
        // メールの表題、本文の作成
        $content = $this->createBodyToManager($customer,$reservation);
        // メール送信

        //　メール送信成否のフラグを返す
        return true;
    }

    /**
     * @param Customer $customer
     * @param Reservation $reservation
     */
    protected function createBodyToCustomer(Customer $customer, Reservation $reservation)
    {
        return true;
    }

    /**
     * @param Customer $customer
     * @param Reservation $reservation
     */
    protected function createBodyToManager(Customer $customer, Reservation $reservation)
    {
        return true;
    }

}



?>