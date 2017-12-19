<?php

namespace Asobiba\Domain\Models\Calendar;

interface CalendarInterface
{
    public function isBusy(string $startDateTime,string $endDateTime);

    public function createEvent(string $startDateTime,string $endDateTime,string $summary = '',string $location = '',string $desc = '');
}