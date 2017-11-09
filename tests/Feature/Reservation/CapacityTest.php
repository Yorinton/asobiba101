<?php

namespace Tests\Feature\Reservation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use DB;

class CapacityTest extends TestCase
{

    use RefreshDatabase;

    public function repository()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);
        return new EloquentReservationRepository;
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
            $id = $this->repository()->nextIdentity();
            createReservation($id,$request);
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
            $id = $this->repository()->nextIdentity();
            createReservation($id,$request);
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
            $id = $this->repository()->nextIdentity();
            createReservation($id,$request);
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
            $id = $this->repository()->nextIdentity();
            createReservation($id,$request);
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
            $id = $this->repository()->nextIdentity();
            createReservation($id,$request);
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
            $id = $this->repository()->nextIdentity();
            createReservation($id,$request);
            $this->assertTrue(true);
        }catch(\InvalidArgumentException $e){
            $this->fail($e->getMessage());
        }       
    }

}
