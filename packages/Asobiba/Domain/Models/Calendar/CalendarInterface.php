<?php

namespace Asobiba\Domain\Models\Calendar;

interface CalendarInterface
{
    public function isEvent(string $date,int $start,int $end);

    public function createEvent(string $startDateTime,string $endDateTime,string $summary = '',string $location = '',string $desc = '');
}