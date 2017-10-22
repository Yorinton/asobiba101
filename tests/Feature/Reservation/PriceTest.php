<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\DateOfUse;


class PriceTest extends TestCase
{

    /**
     * Total price test.
     *
     * @return void
     */
    public function testGetTotalPrice()
    {
        $request = makeCorrectRequest();

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->question
        );
        $this->assertEquals($reservation->totalPrice(),28500);
    }

    /**
     * Get option and Price set.
     *
     * @return void
     */
    public function testGetOptionAndPriceSet()
    {

        $request = makeCorrectRequest();

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->question
        );

        $options = $reservation->optionsAndPrice();
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

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->question
        );

        $this->assertEquals(19500,$reservation->priceOfPlan());
    }

}
