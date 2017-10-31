<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\DateOfUse;


class CapacityTest extends TestCase
{

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

}
