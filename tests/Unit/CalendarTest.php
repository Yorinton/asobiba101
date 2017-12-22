<?php

namespace Tests\Unit;

use Asobiba\Domain\Availability\Availability;
use Asobiba\Domain\Models\Calendar\CalendarInterface;
use Asobiba\Domain\Models\Repositories\Reservation\ReservationRepositoryInterface;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalendarTest extends TestCase
{

    use RefreshDatabase;



    public function repository()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);
        return $this->app->make(ReservationRepositoryInterface::class);
    }

    public function finish()
    {
        //要修正
        DB::delete('delete from reservation_seqs');
        DB::statement("alter table options auto_increment = 1");

    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIsNotBusy()
    {
        date_default_timezone_set('Asia/Tokyo');
        $calendar = $this->app->make(CalendarInterface::class);
        $date = '2017-12-19';
        $start = 17;
        $end = 22;
        $dateArr = explode('-',$date);
        $year = $dateArr[0];
        $month = $dateArr[1];
        $day = $dateArr[2];

        $startDateTime = date('c',mktime($start,0,0,$month,$day,$year));
        $endDateTime = date('c',mktime($end,0,0,$month,$day,$year));
        $this->assertFalse($result = $calendar->isBusy($startDateTime,$endDateTime));
    }

    public function testIsBusy(){

        date_default_timezone_set('Asia/Tokyo');
        $calendar = $this->app->make(CalendarInterface::class);
        $date = '2017-12-19';
        $start = 11;
        $end = 22;
        $dateArr = explode('-',$date);
        $year = $dateArr[0];
        $month = $dateArr[1];
        $day = $dateArr[2];

        $startDateTime = date('c',mktime($start,0,0,$month,$day,$year));
        $endDateTime = date('c',mktime($end,0,0,$month,$day,$year));
        $this->assertTrue($result = $calendar->isBusy($startDateTime,$endDateTime));
    }

    public function testCreateEvent()
    {

        date_default_timezone_set('Asia/Tokyo');

        $calendar = $this->app->make(CalendarInterface::class);
        $date = '2018-01-06';
        $start = 11;
        $end = 22;
        $dateArr = explode('-',$date);
        $year = $dateArr[0];
        $month = $dateArr[1];
        $day = $dateArr[2];

        $startDateTime = date('c',mktime($start,0,0,$month,$day,$year));
        $endDateTime = date('c',mktime($end,0,0,$month,$day,$year));
        $summary = '仮押さえ(自)';

        $eventId = $calendar->createEvent($startDateTime,$endDateTime,$summary);

        $this->assertTrue(true);
    }

    public function testIsNotAvailable()
    {
        try {
            $req = makeCorrectRequest();
            $req->date = '2017-12-19';
            $req->options = array_splice($req->options,0,2);


            $reqArr = reqToArray($req);


            $reservation = $this->repository()->new($reqArr);

            $availability = $this->app->make(Availability::class);
            $availability->isAvailable($reservation);

            $this->finish();
            $this->fail('例外なし');
        }catch(\Exception $e){

            $this->finish();
            $this->assertEquals('ご希望の時間帯は別の方が予約済みです',$e->getMessage());
        }
    }

    public function testIsAvailable()
    {
        try {
            $req = makeCorrectRequest();
            $req->date = '2017-01-19';
            $req->options = array_splice($req->options,0,2);


            $reqArr = reqToArray($req);


            $reservation = $this->repository()->new($reqArr);

            $availability = $this->app->make(Availability::class);

            $this->assertTrue($availability->isAvailable($reservation));
            $this->finish();
        }catch(\Exception $e){

            $this->finish();
            $this->fail('例外発生：'.$e->getMessage());

        }
    }


    public function testKeepDate()
    {
        $req = makeCorrectRequest();
        $req->date = '2018-01-19';
        $req->options = array_splice($req->options,0,2);

        $reqArr = reqToArray($req);

        $reservation = $this->repository()->new($reqArr);

        $availability = $this->app->make(Availability::class);

        $this->assertTrue($availability->keepDate($reservation));

    }
}
