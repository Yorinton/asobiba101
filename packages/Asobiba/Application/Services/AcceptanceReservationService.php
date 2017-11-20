<?php

namespace Asobiba\Application\Service;

use Asobiba\Domain\Models\Notification\ReservationNotificationInterface;
use Asobiba\Domain\Models\Repositories\Reservation\CustomerRepositoryInterface;
use Asobiba\Domain\Models\Repositories\Reservation\ReservationRepositoryInterface;
use Illuminate\Http\Request;

class AcceptanceReservationService
{

    private $customerRepo;
    private $reservationRepo;
    private $notification;

    public function __construct
    (
        CustomerRepositoryInterface $customerRepo,
        ReservationRepositoryInterface $reservationRepo,
        ReservationNotificationInterface $notification
    )
    {
        $this->customerRepo = $customerRepo;
        $this->reservationRepo = $reservationRepo;
        $this->notification = $notification;
    }

    //カスタマーからのリクエストを受け取ってDBに保存 + 自動返信メール送信
    public function reserve(Request $req)//Requestに依存すると独自のリクエストクラスを定義した時にここにも変更を加えないといけない
    {
        //Customerエンティティ生成
        $customerId = $this->customerRepo->nextIdentity();
        $customer = $this->customerRepo->new($customerId, $req);

        //Reservationエンティティ生成
        $reservationId = $this->reservationRepo->nextIdentity();
        $reservation = $this->reservationRepo->new($reservationId, $req);

        //Customer永続化
        $this->customerRepo->persist($customer);
        //Reservation永続化
        $this->reservationRepo->persist($customerId,$reservation);

        //自動メール送信
        $this->notification->notifyToCustomer($customer,$reservation);
        $this->notification->notifyToManager($customer,$reservation);
    }

}

