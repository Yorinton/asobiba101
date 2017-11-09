<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use DB;

class InstantiationTest extends TestCase
{

    use RefreshDatabase;

    public function prepare()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);
    }

    public function repository()
    {
        return new EloquentReservationRepository;
    }

    /**
     * Make Reservation instance test.
     *
     * @return void
     */
    public function testMakeReservation()
    {
        $this->prepare();

        $request = makeCorrectRequest();

        $id = $this->repository()->nextIdentity();
        $reservation = createReservation($id,$request);

        $this->assertTrue(true);
    }

    /**
     *
     * Check if the id is unique
     *
     */
    public function testUniqueId()
    {
        $this->prepare();

        $request = makeCorrectRequest();

        $id = $this->repository()->nextIdentity();
        $reservation = createReservation($id,$request);

        $id2 = $this->repository()->nextIdentity();
        $reservation2 = createReservation($id2,$request);

        $this->assertTrue($reservation->getId() !== $reservation2->getId());
    }

}
