<?php

namespace Asobiba\Application\Service;

use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use Infrastructure\Notification\ReservationMailNotification;

class AcceptanceReservationService
{

    //カスタマーからのリクエストを受け取ってDBに保存 + 自動返信メール送信
    public function reserve(Request $req)
    {
        $repository = new EloquentReservationRepository();
        $id = $repository->nextIdentity();//実装前
        $reservation = new Reservation(
            $id,
            $req->options,
            $req->plan,
            $req->number,
            $req->date,
            $req->start_time,
            $req->end_time,
            $req->question
        );
        $repository->add($reservation);

        $this->sendAutoReply($reservation);
    }

    //自動返信メールをカスタマー・マネージャー両方に送信
    public function sendAutoReply(Reservation $reservation)
    {
        $notification = new ReservationMailNotification();
        $notification->notifyToCustomer($reservation);
        $notification->notifyToManager($reservation);

    }

}


?>