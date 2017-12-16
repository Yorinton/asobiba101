<?php

namespace Asobiba\Domain\Models\Calendar;

interface CalendarInterface
{
    public function isEvent(string $date,int $start,int $end);

    public function createEvent(string $date,int $start,int $end);
}