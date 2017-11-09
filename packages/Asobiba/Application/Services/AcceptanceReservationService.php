<?php

namespace Asobiba\Application\Service;

use Asobiba\Domain\Models\User\Customer;
use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use Infrastructure\Notification\ReservationMailNotification;

class AcceptanceReservationService
{

    //カスタマーからのリクエストを受け取ってDBに保存 + 自動返信メール送信
    public static function reserve(Request $req)
    {
        $repository = new EloquentReservationRepository();
        $id = $repository->nextIdentity();
        $reservation = new Reservation(
            $id,
            $req->options,
            $req->plan,
            $req->number,
            $req->date,
            $req->start_time,
            $req->end_time,
            $req->purpose,
            $req->question
        );
        $customer = new Customer($req->name, $req->email);
        $repository->add($customer, $reservation);

        self::sendAutoReply($reservation);
    }

    //自動返信メールをカスタマー・マネージャー両方に送信
    public static function sendAutoReply(Reservation $reservation)
    {
        return true;
//        $notification = new ReservationMailNotification();
//        $notification->notifyToCustomer($reservation);
//        $notification->notifyToManager($reservation);

    }

}

