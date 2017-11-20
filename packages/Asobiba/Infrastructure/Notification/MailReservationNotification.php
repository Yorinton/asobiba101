<?php

namespace Infrastructure\Notification;

use App\Mail\ToCustomerNotQuestion;
use Asobiba\Domain\Models\Notification\ReservationNotificationInterface;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\User\Customer;
use Mail;

class MailReservationNotification implements ReservationNotificationInterface
{


    public function notifyToCustomer(Customer $customer,Reservation $reservation): bool
    {

        return true;

        Mail::to($customer->getEmail())
            ->send(new ToCustomerNotQuestion($customer,$reservation));


    }


    public function notifyToManager(Customer $customer,Reservation $reservation): bool
    {
        // TODO: Implement notifyToManager() method.
        // メール送信


        //　メール送信成否のフラグを返す
        return true;
    }


}



?>