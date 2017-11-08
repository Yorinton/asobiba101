<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\DateOfUse;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use DB;

class UseDateTimeTest extends TestCase
{
    use RefreshDatabase;

    public function repository()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);
        return new EloquentReservationRepository;
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
            $id = $this->repository()->nextIdentity();
            $reservation = createReservation($id,$request);

            $this->assertTrue(true);
        }catch(\Exception $e){
            $this->fail($e->getMessage());
        }
    }

    public function testNotAcceptableTimeOneDayPlan()
    {
        $request = makeCorrectRequest();
        $request->end_time = '23';
        array_splice($request->options,2,1);
        try{
            $id = $this->repository()->nextIdentity();
            $reservation = createReservation($id,$request);

            $this->fail('例外発生無し');
        }catch(\Exception $e){
            $this->assertEquals('不正な開始時刻又は終了時刻が入力されています',$e->getMessage());
        }
    }

    public function testNotAcceptableTimeShortPlan()
    {
        $request = makeCorrectRequest();
        $request->plan = '【商用】3時間パック';
        $request->start_time = 15;
        $request->end_time = 18;
        array_splice($request->options,2,1);
        try{
            $id = $this->repository()->nextIdentity();
            $reservation = createReservation($id,$request);

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
            $id = $this->repository()->nextIdentity();
            $reservation = createReservation($id,$request);

            $this->fail('例外発生無し');
        }catch(\Exception $e){
            $this->assertEquals('プランで指定された利用時間をオーバーしています',$e->getMessage());
        }
    }


    public function testEditEndTimeDependentOptions()
    {
        //宿泊オプション
        $request = makeOtherRequest();

        try {
            $id = $this->repository()->nextIdentity();
            $reservation = createReservation($id,$request);

            $this->assertEquals($reservation->getEndTime(), 9);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        //深夜利用オプション
        $request = makeCorrectRequest();
        $request->options[2] = '深夜利用';
        try {
            $id = $this->repository()->nextIdentity();
            $reservation = createReservation($id,$request);

            $this->assertEquals($reservation->getEndTime(), 24);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testNotAcceptDayTimePlanAndMidnightOrStayOptions()
    {

        $request = makeCorrectRequest();
        $request->plan = '【商用】お昼5時間パック';
        try {
            $id = $this->repository()->nextIdentity();
            $reservation = createReservation($id,$request);

            $this->fail('例外無し');
        } catch (\Exception $e) {
            $this->assertEquals('お昼プランの場合、深夜利用・宿泊オプションは利用出来ません', $e->getMessage());
        }
    }

    public function testNotAcceptedEndTimeAndMidnightOrStayOptions()
    {
        $request = makeOtherRequest();
        $request->start_time = 17;
        $request->end_time = 20;
        try{
            $id = $this->repository()->nextIdentity();
            $reservation = createReservation($id,$request);

            $this->fail('例外無し');
        }catch(\Exception $e){
            $this->assertEquals('深夜利用or宿泊オプションご希望の場合は、22時までのプランをご利用下さい',$e->getMessage());
        }
    }

}
