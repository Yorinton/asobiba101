<?php

namespace Asobiba\Domain\Models\Calendar;

interface CalendarInterface
{
    public function isEvent();

    public function createEvent();
}