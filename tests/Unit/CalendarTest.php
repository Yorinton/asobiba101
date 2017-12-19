<?php

namespace Tests\Unit;

use Asobiba\Domain\Models\Calendar\CalendarInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalendarTest extends TestCase
{
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

        dd($eventId);
    }
}
