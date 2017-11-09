<?php

namespace Tests\Feature\Reservation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use DB;

class PriceTest extends TestCase
{
    use RefreshDatabase;

    public function repository()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);
        return new EloquentReservationRepository;
    }
    /**
     * Total price test.
     *
     * @return void
     */
    public function testGetTotalPrice()
    {
        $request = makeCorrectRequest();

        $id = $this->repository()->nextIdentity();
        $reservation = createReservation($id,$request);
        $this->assertEquals($reservation->getTotalPrice(),28500);
    }

    /**
     * Get option and Price set.
     *
     * @return void
     */
    public function testGetOptionAndPriceSet()
    {

        $request = makeCorrectRequest();

        $id = $this->repository()->nextIdentity();
        $reservation = createReservation($id,$request);

        $options = $reservation->getOptionAndPriceSet();

        $this->assertEquals($options,['ゴミ処理' => 1500,'カセットコンロ' => 1500,'宿泊(1〜3名様)' => 6000]);

    }

    /**
     * Get base price of plan.
     *
     * @return void
     */
    public function testGetPriceOfPlan()
    {
        $request = makeCorrectRequest();

        $id = $this->repository()->nextIdentity();
        $reservation = createReservation($id,$request);

        $this->assertEquals(19500,$reservation->getPriceOfPlan());
    }

}
