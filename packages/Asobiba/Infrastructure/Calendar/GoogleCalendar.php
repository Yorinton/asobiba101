<?php

namespace Asobiba\Infrastructure\Calendar;

use Asobiba\Domain\Models\Calendar\CalendarInterface;

class GoogleCalendar implements CalendarInterface
{

    public function isEvent(string $date,int $start,int $end): bool
    {
        // TODO: Implement isEvent() method.
        return false;
    }

    public function createEvent(string $date,int $start,int $end): bool
    {
        // TODO: Implement createEvent() method.
        return true;
    }
}