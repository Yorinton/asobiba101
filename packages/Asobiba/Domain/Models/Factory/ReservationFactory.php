<?php

namespace Asobiba\Domain\Models\Factory;

use Asobiba\Domain\Models\Repositories\Reservation\CustomerRepositoryInterface;
use Asobiba\Domain\Models\Reservation\Capacity;
use Asobiba\Domain\Models\Reservation\DateOfUse;
use Asobiba\Domain\Models\Reservation\Number;
use Asobiba\Domain\Models\Reservation\Options;
use Asobiba\Domain\Models\Reservation\Plan;
use Asobiba\Domain\Models\Reservation\Purpose;
use Asobiba\Domain\Models\Reservation\Question;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\ReservationId;

class ReservationFactory
{

    private $customerRepo;

    public function __construct(CustomerRepositoryInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }


    public function createFromRequest(ReservationId $reservationId, array $req):Reservation
    {

        $customer = $this->customerRepo->new($req);

        return new Reservation(
            $reservationId,
            $customer,
            $plan = new Plan($req['plan']),
            $options = new Options($req['options'], $plan, $req['end_time']),
            new DateOfUse($req['date'], $req['start_time'], $req['end_time'], $plan, $options),
            $capacity = new Capacity($plan, $options),
            new Number($req['number'], $capacity),
            new Purpose($req['purpose']),
            new Question($req['question'])
        );
    }
}