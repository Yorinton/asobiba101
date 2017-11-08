<?php

namespace Asobiba\Infrastructure\Repositories;

use App\Eloquents\Reservation\EloquentReservation;
use App\Eloquents\Reservation\EloquentOption;
use Asobiba\Domain\Models\Repositories\Reservation\ReservationRepositoryInterface;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\ReservationId;
use DB;


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
        if(!$reservation->getOptionAndPriceSet()) {
            return;
        }
        foreach ($reservation->getOptionAndPriceSet() as $name => $price) {
            $option = new EloquentOption();
            $option->name = $name;
            $option->price = $price;
            $eloquentReservation->options()->save($option);
        }

    }

    public function nextIdentity(): ReservationId
    {
        //nextvalに識別子となる値を挿入
        DB::table('reservation_seqs')->update(["nextval" => DB::raw("LAST_INSERT_ID(nextval + 1)")]);
        //識別子取得 selectでBuilderインスタンスを返して、getでCollectionを返す、firstでEloquent\Modelインスタンスを返す
        $reservationIdObj = DB::table('reservation_seqs')->selectRaw("LAST_INSERT_ID()")->first();
        $reservationId = get_object_vars($reservationIdObj)["LAST_INSERT_ID()"];

        return new ReservationId($reservationId);
    }
}


?>