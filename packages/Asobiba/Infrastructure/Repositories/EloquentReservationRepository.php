<?php

namespace Asobiba\Infrastructure\Repositories;

use App\Eloquents\Reservation\EloquentReservation;
use App\Eloquents\Reservation\EloquentOption;
use Asobiba\Domain\Models\Repositories\Reservation\ReservationRepositoryInterface;
use Asobiba\Domain\Models\Reservation\Reservation;

class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function add(Reservation $reservation)
    {
        //Reservationの永続化
        $eloquentReservation = new EloquentReservation();
        $eloquentReservation->id = $reservation->getId();
        $eloquentReservation->plan = $reservation->getPlanName();
        $eloquentReservation->price = $reservation->getTotalPrice();

        //以下EloquentReservationを通してDBにreservationの値を登録していく
        // ・・・

        $eloquentReservation->save();

        //Reservationと関連するオプションの永続化
        if(!$reservation->optionsAndPrice()) {
            return;
        }
        foreach ($reservation->optionsAndPrice() as $name => $price) {
            $option = new EloquentOption();
            $option->name = $name;
            $option->price = $price;
            $eloquentReservation->options()->save($option);
        }

    }
}


?>