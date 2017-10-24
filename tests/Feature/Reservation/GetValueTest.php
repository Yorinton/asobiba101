<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\DateOfUse;


class GetValueTest extends TestCase
{

    /**
     *
     * Get plan name.
     *
     */
    public function testGetPlanName()
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
        $this->assertEquals('【非商用】基本プラン(平日)',$reservation->planName());
    }

    /**
     * Get date & time.
     */
    public function testGetDateTime()
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
        $this->assertEquals('2017-11-26',$reservation->getDateOfUse()->getDate());
        $this->assertEquals(11,$reservation->getDateOfUse()->getStartTime());
        $this->assertEquals(9,$reservation->getDateOfUse()->getEndTime());

        $request->options[2] = '';//宿泊オプションを削除
        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->question
        );
        $this->assertEquals(22,$reservation->getDateOfUse()->getEndTime());

        $request->options[2] = '深夜利用';//宿泊オプションを深夜利用に変更
        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->question
        );
        $this->assertEquals(24,$reservation->getDateOfUse()->getEndTime());

    }

    /**
     * Get status of this reservation.
     */
    public function testGetStatus()
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
        $this->assertEquals('Contact',$reservation->getStatus());
        $reservation->confirmReservation();
        $this->assertEquals('Confirmation',$reservation->getStatus());
//        $this->assertEquals(3,$reservation->sentProcedureInfo());
//        $this->assertEquals(4,$reservation->confirmPayment());
//        $this->assertEquals(5,$reservation->sentAccess());
//        $this->assertEquals(6,$reservation->used());
    }

}
