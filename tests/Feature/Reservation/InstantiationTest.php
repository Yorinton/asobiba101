<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\DateOfUse;


class InstantiationTest extends TestCase
{

    /**
     * Make Reservation instance test.
     *
     * @return void
     */
    public function testMakeReservation()
    {

        $request = makeCorrectRequest();

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->purpose,
            $request->question
        );

        $this->assertTrue(true);
    }

    /**
     *
     * Check if the id is unique
     *
     */
    public function testUniqueId()
    {
        $request = makeCorrectRequest();

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->purpose,
            $request->question
        );

        $reservation2 = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->purpose,
            $request->question
        );

        $this->assertTrue($reservation->getId()->getId() !== $reservation2->getId()->getId());
    }

}
