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

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
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
     * Capacity test.
     *
     * @return void
     */
    public function testOverCapacityNotBusinessPlan()
    {
        $request = makeCorrectRequest();
        $request->number = 13;

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
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

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
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

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
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

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
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

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
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

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
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

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->question
        ); 

        $this->assertEquals('途中退出ありですか？',$reservation->Question());
    }

    public function testCheckHasQuestion()
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

        $this->assertTrue($reservation->hasQuestion()); 
    }

    public function testCheckNotHasQuestion()
    {
        $request = makeCorrectRequest();
        unset($request->question);

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
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

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
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
        $request->options[2] = '';

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
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
        $request->start_time = 15;
        $request->end_time = 18;
        $request->options[2] = '';

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
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
        $request->start_time = 17;
        $request->end_time = 22;

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
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


        try {
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
                $request->question
            );
            $reservation2 = new Reservation(
                $request2->options,
                $request2->plan,
                $request2->number,
                $request2->date,
                $request2->start_time,
                $request2->end_time,
                $request2->question
            );
            $reservation3 = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
                $request->question
            );
            $this->assertEquals($reservation->getNumber()->getNumberOfGuests(),$reservation2->getNumber()->getNumberOfGuests());
            $this->assertTrue($reservation->totalPrice() !== $reservation2->totalPrice());
            $this->assertTrue($reservation !== $reservation3);//同じ値を代入しても異なるオブジェクトになる
            $this->assertTrue(true);
        }catch(\Exception $e){
            $this->fail($e->getMessage());
        }
    }

    public function testEditEndTimeDependentOptions()
    {
        $request = makeOtherRequest();

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
                $request->question
            );
            $this->assertEquals($reservation->getDateOfUse()->getEndTime(),9);
        }catch(\Exception $e){
            $this->fail($e->getMessage());
        }

        $request = makeCorrectRequest();
        $request->options[2] = '深夜利用';
        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
                $request->question
            );
            $this->assertEquals($reservation->getDateOfUse()->getEndTime(),24);
        }catch(\Exception $e){
            $this->fail($e->getMessage());
        }

        $request = makeCorrectRequest();
        $request->plan = '【商用】お昼5時間パック';
        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
                $request->question
            );
            $this->fail('例外無し');
        }catch(\Exception $e){
            $this->assertEquals('深夜利用or宿泊オプションご希望の場合は「基本プラン」か「夜5時間パック」、もしくは夜22時まで利用するプランをご利用下さい',$e->getMessage());
        }
    }

}
