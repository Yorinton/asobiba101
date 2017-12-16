<?php

namespace Asobiba\Domain\Availability;

use Asobiba\Domain\Models\Calendar\CalendarInterface;

class Availability
{

    private $calendar;

    public function __construct(CalendarInterface $calendar)
    {
        $this->calendar = $calendar;
    }


    /**
     * 空き状況チェック
     * @return bool
     */
    public function isAvailable(): bool
    {

    }

    //予約追加の成否をbooleanで返す
    public function addReservation(): bool
    {

    }
}
