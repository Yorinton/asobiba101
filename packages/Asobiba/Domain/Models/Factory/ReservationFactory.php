<?php

namespace Asobiba\Domain\Models\Factory;

use Asobiba\Domain\Models\Reservation\Capacity;
use Asobiba\Domain\Models\Reservation\DateOfUse;
use Asobiba\Domain\Models\Reservation\Number;
use Asobiba\Domain\Models\Reservation\Options;
use Asobiba\Domain\Models\Reservation\Plan;
use Asobiba\Domain\Models\Reservation\Purpose;
use Asobiba\Domain\Models\Reservation\Question;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\ReservationId;
use Illuminate\Http\Request;

class ReservationFactory
{

    public function createFromRequest(ReservationId $reservationId, Request $req):Reservation
    {
        return new Reservation(
            $reservationId,
            $plan = new Plan($req->plan),
            $options = new Options($req->options, $req->plan, $req->end_time),
            new DateOfUse($req->date, $req->start_time, $req->end_time, $req->plan, $req->options),
            $capacity = new Capacity($plan, $options),
            new Number($req->number, $capacity),
            new Purpose($req->purpose),
            new Question($req->question)
        );
    }
}