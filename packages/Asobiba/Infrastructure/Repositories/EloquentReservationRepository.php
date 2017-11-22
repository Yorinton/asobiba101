<?php

namespace Asobiba\Infrastructure\Repositories;

use App\Eloquents\Reservation\EloquentReservation;
use App\Eloquents\Reservation\EloquentOption;
use App\Eloquents\User\EloquentCustomer;
use Asobiba\Domain\Models\Factory\ReservationFactory;
use Asobiba\Domain\Models\Repositories\Reservation\CustomerRepositoryInterface;
use Asobiba\Domain\Models\Repositories\Reservation\ReservationRepositoryInterface;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\ReservationId;
use Asobiba\Domain\Models\User\Customer;
use Asobiba\Domain\Models\User\CustomerId;
use DB;
use Illuminate\Http\Request;


class EloquentReservationRepository implements ReservationRepositoryInterface
{

    private $factory;
    private $customerRepo;
    private $sequence_table_name = 'reservation_seqs';


    public function __construct(ReservationFactory $factory)
    {
        $this->factory = $factory;
    }


    public function nextIdentity(): ReservationId
    {
        DB::table($this->sequence_table_name)->update(["nextval" => DB::raw("LAST_INSERT_ID(nextval + 1)")]);
        $reservationId = DB::table($this->sequence_table_name)->selectRaw("LAST_INSERT_ID() as id")->first()->id;

        return new ReservationId($reservationId);
    }


    public function new(Request $req): Reservation
    {
        $reservationId = $this->nextIdentity();
        return $this->factory->createFromRequest($reservationId, $req);
    }

    public function persist(Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            //Reservationの永続化
            $eloquentReservation = new EloquentReservation();
            $eloquentReservation->id = $reservation->getId();
            $eloquentReservation->customer_id = $reservation->getCustomer()->getId()->getId();
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

}
