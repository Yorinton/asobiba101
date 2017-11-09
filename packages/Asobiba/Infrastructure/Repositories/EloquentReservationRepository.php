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
        DB::beginTransaction();
        try {
            //Reservationの永続化
            $eloquentReservation = new EloquentReservation();
            $eloquentReservation->id = $reservation->getId();
            $eloquentReservation->plan = $reservation->getPlanName();
            $eloquentReservation->price = $reservation->getPriceOfPlan();
            $eloquentReservation->number = $reservation->getNumber();
            $eloquentReservation->date = $reservation->getDate();
            $eloquentReservation->start_time = $reservation->getStartTime();
            $eloquentReservation->end_time = $reservation->getEndTime();
            $eloquentReservation->question = $reservation->getQuestion();
            $eloquentReservation->status = $reservation->getStatus();

            $eloquentReservation->save();

            //Reservationと関連するオプションの永続化(別リポジトリに移す)
            if (!$reservation->getOptionAndPriceSet()) {
                return;
            }
            foreach ($reservation->getOptionAndPriceSet() as $name => $price) {
                $option = new EloquentOption();
                $option->name = $name;
                $option->price = $price;
                $eloquentReservation->options()->save($option);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            dd($e->getMessage());
        }

    }

    public function nextIdentity(): ReservationId
    {
        //nextvalに識別子となる値を挿入
        DB::table('reservation_seqs')->update(["nextval" => DB::raw("LAST_INSERT_ID(nextval + 1)")]);
        //識別子取得 selectでBuilderインスタンスを返して、getでCollectionを返す、firstでEloquent\Modelインスタンスを返す
        $reservationId = DB::table('reservation_seqs')->selectRaw("LAST_INSERT_ID()")->first()->{'LAST_INSERT_ID()'};

        return new ReservationId($reservationId);
    }
}


?>