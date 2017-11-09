<?php

namespace Asobiba\Infrastructure\Repositories;

use App\Eloquents\Reservation\EloquentReservation;
use App\Eloquents\Reservation\EloquentOption;
use App\Eloquents\User\EloquentCustomer;
use Asobiba\Domain\Models\Repositories\Reservation\ReservationRepositoryInterface;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\ReservationId;
use Asobiba\Domain\Models\User\Customer;
use DB;


class EloquentReservationRepository implements ReservationRepositoryInterface
{
    /**
     * @param Reservation $reservation
     */
    public function add(Customer $customer, Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            //Customerの永続化
            $eloquentCustomer = new EloquentCustomer();
            $eloquentCustomer->name = $customer->getCustomerName();
            $eloquentCustomer->email = $customer->getCustomerEmail();
            $eloquentCustomer->save();

            //Reservationの永続化
            $eloquentReservation = new EloquentReservation();
            $eloquentReservation->id = $reservation->getId();
            $eloquentReservation->customer_id = $eloquentCustomer->id;
            $eloquentReservation->plan = $reservation->getPlanName();
            $eloquentReservation->price = $reservation->getPriceOfPlan();
            $eloquentReservation->number = $reservation->getNumber();
            $eloquentReservation->date = $reservation->getDate();
            $eloquentReservation->start_time = $reservation->getStartTime();
            $eloquentReservation->end_time = $reservation->getEndTime();
            $eloquentReservation->question = $reservation->getQuestion();
            $eloquentReservation->status = $reservation->getStatus();
            $eloquentReservation->save();

            //Reservationと関連するオプションの永続化
            if ($reservation->getOptionAndPriceSet()) {
                foreach ($reservation->getOptionAndPriceSet() as $optionName => $price) {
                    $option = new EloquentOption();
                    $option->reservation_id = $reservation->getId();
                    $option->option = $optionName;
                    $option->price = $price;
                    $option->save();
                }
            }

            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();
            dd($e->getMessage());

        }

    }

    public function nextIdentity(): ReservationId
    {
        DB::table('reservation_seqs')->update(["nextval" => DB::raw("LAST_INSERT_ID(nextval + 1)")]);
        $reservationId = DB::table('reservation_seqs')->selectRaw("LAST_INSERT_ID() as id")->first()->id;

        return new ReservationId($reservationId);
    }
}
