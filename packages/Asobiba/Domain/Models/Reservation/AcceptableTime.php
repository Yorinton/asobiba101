<?php

namespace Asobiba\Domain\Models\Reservation;

class AcceptableTime
{
    private const startTimeOfPlanSet = [

        '【非商用】基本プラン(平日)' => 11,
        '【非商用】基本プラン(休日)' => 11,
        '【非商用】お昼5時間パック' => 11,
        '【非商用】夜5時間パック' => 17,
        '【商用】基本１日プラン' => 11,
        '【商用】お昼5時間パック' => 11,
        '【商用】夜5時間パック' => 17,
        '【商用】3時間パック' => 11,
        '【商用】2時間パック' => 11,
    ];

    private const endTimeOfPlanSet = [

        '【非商用】基本プラン(平日)' => 22,
        '【非商用】基本プラン(休日)' => 22,
        '【非商用】お昼5時間パック' => 16,
        '【非商用】夜5時間パック' => 22,
        '【商用】基本１日プラン' => 22,
        '【商用】お昼5時間パック' => 16,
        '【商用】夜5時間パック' => 22,
        '【商用】3時間パック' => 22,
        '【商用】2時間パック' => 22,
    ];


    public static function acceptableStartTime(Plan $plan): int
    {
        return self::startTimeOfPlanSet[$plan->getPlan()];
    }

    public static function acceptableEndTime(Plan $plan): int
    {
        return self::endTimeOfPlanSet[$plan->getPlan()];
    }
}