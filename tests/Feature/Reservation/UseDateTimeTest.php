<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\DateOfUse;


class UseDateTimeTest extends TestCase
{

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


    public function testEditEndTimeDependentOptions()
    {
        //宿泊オプション
        $request = makeOtherRequest();

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
            $this->assertEquals($reservation->getDateOfUse()->getEndTime(), 9);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        //深夜利用オプション
        $request = makeCorrectRequest();
        $request->options[2] = '深夜利用';
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
            $this->assertEquals($reservation->getDateOfUse()->getEndTime(), 24);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function notAcceptDayTimePlanAndMidnightOrStayOptions()
    {

        $request = makeCorrectRequest();
        $request->plan = '【商用】お昼5時間パック';
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
            $this->fail('例外無し');
        } catch (\Exception $e) {
            $this->assertEquals('深夜利用or宿泊オプションご希望の場合は「基本プラン」か「夜5時間パック」、もしくは夜22時まで利用するプランをご利用下さい', $e->getMessage());
        }
    }

    public function notAcceptedEndTimeAndMidnightOrStayOptions()
    {
        $request = makeOtherRequest();
        $request->start_time = 17;
        $request->end_time = 20;
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
            $this->assertEquals('深夜利用or宿泊オプションご希望の場合は、22時までのプランをご利用下さい',$e->getMessage());
        }
    }

}
