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
    public function testIsNotEvent()
    {
        $calendar = $this->app->make(CalendarInterface::class);
        $date = '2018-01-23';
        $start = 11;
        $end = 22;

        $this->assertFalse($calendar->isEvent($date,$start,$end));
    }

    public function testIsEvent(){
        $calendar = $this->app->make(CalendarInterface::class);
        $date = '2018-01-07';
        $start = 11;
        $end = 22;

        $this->assertTrue($calendar->isEvent($date,$start,$end));
    }
}
