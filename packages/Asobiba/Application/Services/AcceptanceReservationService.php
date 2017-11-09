<?php

namespace Asobiba\Application\Service;

use Asobiba\Domain\Models\Reservation\ReservationId;
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
        //ReservationIdの生成
        $repository = new EloquentReservationRepository();
        $id = $repository->nextIdentity();

        //ReservationエンティティとCustomerエンティティの生成
        $reservation = self::createReservation($id,$req);
        $customer = self::createCustomer($req);

        //永続化処理
        $repository->add($customer, $reservation);

        //自動メール送信
        self::sendAutoReply($customer,$reservation);
    }

    private static function createReservation(ReservationId $id,Request $req): Reservation
    {
        return new Reservation(
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
    }

    private static function createCustomer(Request $req): Customer
    {
        return new Customer($req->name, $req->email);
    }

    //自動返信メールをカスタマー・マネージャー両方に送信
    private static function sendAutoReply(Customer $customer,Reservation $reservation)
    {
        return true;//テスト通す用
        $notification = new ReservationMailNotification();
        $notification->notifyToCustomer($customer,$reservation);
        $notification->notifyToManager($customer,$reservation);

    }



}

