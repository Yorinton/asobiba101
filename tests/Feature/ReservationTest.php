<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\DateOfUse;


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

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $dateOfUse,
            $request->question
        );

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

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $dateOfUse,
            $request->question
        );
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

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,
                $request->question
            );          
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

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,
                $request->question
            );             
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

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,
                $request->question
            );             
            $this->fail('例外発生無し');
        }catch(\InvalidArgumentException $e){
            $this->assertEquals('適切な利用人数を設定して下さい',$e->getMessage());
        }
    }


    public function testCapacityOkNotBusinessPlan()
    {
        $request = makeCorrectRequest();
        $request->number = 11;

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,
                $request->question
            ); 
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

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,
                $request->question
            ); 
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

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,
                $request->question
            ); 
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

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $dateOfUse,
            $request->question
        ); 

        $this->assertEquals('途中退出ありですか？',$reservation->Question());
    }

    public function testCheckHasQuestion()
    {
        $request = makeCorrectRequest();

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $dateOfUse,
            $request->question
        ); 

        $this->assertTrue($reservation->hasQuestion()); 
    }

    public function testCheckNotHasQuestion()
    {
        $request = makeCorrectRequest();
        unset($request->question);

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $dateOfUse,                
            $request->question
        ); 

        $this->assertTrue(!$reservation->hasQuestion()); 
    }

    /**
     * Date test.
     *
     * @return void
     */
    public function testIsAcceptableTimeOneDayPlan()
    {
        $request = makeCorrectRequest();

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,                
                $request->question
            );
            $this->assertTrue(true);
        }catch(\Exception $e){
            $this->fail($e->getMessage());
        }
    }

    public function testNotAcceptableTimeOneDayPlan()
    {
        $request = makeCorrectRequest();
        $request->end_time = '23';

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,                
                $request->question
            );
            $this->assertTrue(true);
            $this->fail('例外発生無し');
        }catch(\Exception $e){
            $this->assertEquals('開始時間又は終了時間が適切ではありません',$e->getMessage());
        }
    }

    public function testNotAcceptableTimeShortPlan()
    {
        $request = makeCorrectRequest();
        $request->plan = '【商用】3時間パック';

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,                
                $request->question
            );
            $this->assertTrue(true);
            $this->fail('例外発生無し');
        }catch(\Exception $e){
            $this->assertEquals('2or3時間パックの場合16時~17時以外で指定して下さい',$e->getMessage());
        }
    }

    public function testNotAcceptableUtilizationTimeShortPlan()
    {
        $request = makeCorrectRequest();
        $request->plan = '【商用】3時間パック';
        $request->start_time = '11';
        $request->end_time = '16';

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,                
                $request->question
            );
            $this->assertTrue(true);
            $this->fail('例外発生無し');
        }catch(\Exception $e){
            $this->assertEquals('プランで指定された利用時間をオーバーしています',$e->getMessage());
        }
    }

    public function testOtherNameReference()
    {
        $request = makeCorrectRequest();
        $request2 = makeOtherRequest();

        $dateOfUse = new DateOfUse($request->date,$request->start_time,$request->end_time);
        $dateOfUse2 = new DateOfUse($request2->date,$request2->start_time,$request2->end_time);

        try {
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,
                $request->question
            );
            $reservation2 = new Reservation(
                $request2->options,
                $request2->plan,
                $request2->number,
                $dateOfUse2,
                $request2->question
            );
            $reservation3 = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $dateOfUse,
                $request->question
            );
            $this->assertEquals($reservation->getNumber()->getNumberOfGuests(),$reservation2->getNumber()->getNumberOfGuests());
            $this->assertTrue($reservation->totalPrice() !== $reservation2->totalPrice());
            $this->assertTrue($reservation !== $reservation3);//同じ値を代入しても異なるオブジェクトになる
        }catch(\Exception $e){
            $this->fail($e->getMessage());
        }
    }

}
