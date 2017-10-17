<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;

class ReservationTest extends TestCase
{

    /**
     * Make Reservation instance test.
     *
     * @return void
     */
    public function testMakeReservation()
    {

        $request = makeCorrectRequest();
        $reservation = new Reservation($request);

        $this->assertTrue(true);
    }


    /**
     * Total price test.
     *
     * @return void
     */
    public function testGetTotalPrice()
    {
        $request = makeCorrectRequest();
        $reservation = new Reservation($request);

        $this->assertEquals($reservation->totalPrice(),28500);
    }

    /**
     * Capacity test.
     *
     * @return void
     */
    public function testOverCapacityNotBusinessPlan()
    {
        $request = makeCorrectRequest();
        $request->number = 13;
        try{
            $reservation = new Reservation($request);
            $this->fail('例外発生無し');
        }catch(\InvalidArgumentException $e){
            $this->assertEquals('適切な利用人数を設定して下さい',$e->getMessage());
        }
    }

    public function testOverCapacityBusinessPlan()
    {
        $request = makeCorrectRequest();
        $request->plan = '【商用】基本１日プラン';
        $request->number = 16;
        try{
            $reservation = new Reservation($request);
            $this->fail('例外発生無し');
        }catch(\InvalidArgumentException $e){
            $this->assertEquals('適切な利用人数を設定して下さい',$e->getMessage());
        }
    }


    public function testOverCapacityNotBusinessPlanWithLargeGroupOption()
    {
        $request = makeCorrectRequest();
        $request->options[] = '大人数レイアウト';
        $request->number = 16;
        try{
            $reservation = new Reservation($request);
            $this->fail('例外発生無し');
        }catch(\InvalidArgumentException $e){
            $this->assertEquals('適切な利用人数を設定して下さい',$e->getMessage());
        }
    }


    public function testCapacityOkNotBusinessPlan()
    {
        $request = makeCorrectRequest();
        $request->number = 11;
        try{
            $reservation = new Reservation($request);
            $this->assertTrue(true);
        }catch(\InvalidArgumentException $e){
            $this->fail($e->getMessage());
        }       

    }

    public function testCapacityOkBusinessPlan()
    {
        $request = makeCorrectRequest();
        $request->plan = '【商用】基本１日プラン';
        $request->number = 13;
        try{
            $reservation = new Reservation($request);
            $this->assertTrue(true);
        }catch(\InvalidArgumentException $e){
            $this->fail($e->getMessage());
        }       
    }

    public function testCapacityOkNotBusinessPlanWithLargeGroupOption()
    {
        $request = makeCorrectRequest();
        $request->options[] = '大人数レイアウト';
        $request->number = 15;
        try{
            $reservation = new Reservation($request);
            $this->assertTrue(true);
        }catch(\InvalidArgumentException $e){
            $this->fail($e->getMessage());
        }       
    }

    /**
     * Question test.
     *
     * @return void
     */
    public function testGetQuestion()
    {
        $request = makeCorrectRequest();
        $reservation = new Reservation($request);

        $this->assertEquals('途中退出ありですか？',$reservation->Question());
    }

    public function testCheckHasQuestion()
    {
        $request = makeCorrectRequest();
        $reservation = new Reservation($request);

        $this->assertTrue($reservation->hasQuestion()); 
    }

    public function testCheckNotHasQuestion()
    {
        $request = makeCorrectRequest();
        unset($request->question);
        // $request->question = '';
        $reservation = new Reservation($request);

        $this->assertTrue(!$reservation->hasQuestion()); 
    }


}
