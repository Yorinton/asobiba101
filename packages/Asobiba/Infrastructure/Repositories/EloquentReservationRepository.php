<?php

namespace Asobiba\Infrastructure\Repositories;

use App\Eloquents\Reservation\EloquentReservation;
use App\Eloquents\Reservation\EloquentOption;
use Asobiba\Domain\Models\Factory\ReservationFactory;
use Asobiba\Domain\Models\Repositories\Reservation\CustomerRepositoryInterface;
use Asobiba\Domain\Models\Repositories\Reservation\ReservationRepositoryInterface;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\ReservationId;
use DB;


class EloquentReservationRepository implements ReservationRepositoryInterface
{

    private $factory;
    private $customerRepo;
    private $sequence_table_name = 'reservation_seqs';


    public function __construct(ReservationFactory $factory, CustomerRepositoryInterface $customerRepo)
    {
        $this->factory = $factory;
        $this->customerRepo = $customerRepo;
    }


    public function nextIdentity(): ReservationId
    {
        DB::table($this->sequence_table_name)->update(["nextval" => DB::raw("LAST_INSERT_ID(nextval + 1)")]);
        $reservationId = DB::table($this->sequence_table_name)->selectRaw("LAST_INSERT_ID() as id")->first()->id;

        return new ReservationId($reservationId);
    }


    public function new(array $req): Reservation
    {
        //エンティティの一意な識別子を生成
        $customerId = $this->customerRepo->nextIdentity();
        $reservationId = $this->nextIdentity();

        //Reservationエンティティの生成
        return $this->factory->createFromRequest($customerId, $reservationId, $req);
    }

    public function persist(Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            //Reservationの永続化
            $eloquentReservation = new EloquentReservation();
            $eloquentReservation->id = $reservation->getId()->getId();
            $eloquentReservation->customer_id = $reservation->getCustomer()->getId()->getId();
            $eloquentReservation->plan = $reservation->getPlan()->getPlan();
            $eloquentReservation->price = $reservation->getPlan()->getPrice();
            $eloquentReservation->number = $reservation->getNumber()->getNumber();
            $eloquentReservation->date = $reservation->getDate()->getDate();
            $eloquentReservation->start_time = $reservation->getDate()->getStartTime();
            $eloquentReservation->end_time = $reservation->getDate()->getEndTime();
            $eloquentReservation->question = $reservation->getQuestion()->getQuestion();
            $eloquentReservation->status = $reservation->getStatus();
            $eloquentReservation->save();

            //Reservationと関連するオプションの永続化
            if ($reservation->getOptionAndPriceSet()) {
                foreach ($reservation->getOptionAndPriceSet() as $optionName => $price) {
                    $option = new EloquentOption();
                    $option->reservation_id = $reservation->getId()->getId();
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
