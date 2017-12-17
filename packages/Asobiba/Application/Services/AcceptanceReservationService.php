<?php

namespace Asobiba\Application\Service;

use Asobiba\Domain\Availability\Availability;
use Asobiba\Domain\Models\Factory\ReservationFactory;
use Asobiba\Domain\Models\Notification\ReservationNotificationInterface;
use Asobiba\Domain\Models\Repositories\Reservation\CustomerRepositoryInterface;
use Asobiba\Domain\Models\Repositories\Reservation\ReservationRepositoryInterface;
use Asobiba\Domain\Models\Reservation\Reservation;

class AcceptanceReservationService
{

    private $customerRepo;
    private $reservationRepo;
    private $notification;
    private $availability;

    public function __construct
    (
        CustomerRepositoryInterface $customerRepo,
        ReservationRepositoryInterface $reservationRepo,
        ReservationNotificationInterface $notification,
        Availability $availability
    )
    {
        $this->customerRepo = $customerRepo;
        $this->reservationRepo = $reservationRepo;
        $this->notification = $notification;
        $this->availability = $availability;
    }

    //カスタマーからのリクエストを受け取ってDBに保存 + 自動返信メール送信
    public function reserve(array $req)//Requestに依存すると独自のリクエストクラスを定義した時にここにも変更を加えないといけない
    {

        //Reservationエンティティ生成
        $reservation = $this->reservationRepo->new($req);

        //空き状況チェック
        $this->isAvailable($reservation);
        //日程確保
        $this->keepDate($reservation);

        //Reservation永続化
        $this->reservationRepo->persist($reservation);
        //空き状況の永続化?

        //自動メール送信
        $this->notification->notifyToCustomer($reservation);
        $this->notification->notifyToManager($reservation);

    }


    private function isAvailable(Reservation $reservation): bool
    {
        return $this->availability->isAvailable($reservation);
    }

    private function keepDate(Reservation $reservation)
    {
        $this->availability->keepDate($reservation);
    }

}

