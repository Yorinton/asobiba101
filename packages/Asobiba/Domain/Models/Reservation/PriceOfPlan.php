<?php

namespace Asobiba\Domain\Models\Reservation;

class PriceOfPlan
{
    private const PriceOfPlanSet = [

        '【非商用】基本プラン(平日)' => 19500,
        '【非商用】基本プラン(休日)' => 20500,
        '【非商用】お昼5時間パック' => 17000,
        '【非商用】夜5時間パック' => 18000,
        '【商用】基本１日プラン' => 28500,
        '【商用】お昼5時間パック' => 24000,
        '【商用】夜5時間パック' => 25000,
        '【商用】3時間パック' => 20000,
        '【商用】2時間パック' => 17000,
    ];

    public static function getPrice(Plan $plan): int
    {
        return self::PriceOfPlanSet[$plan->getPlan()];
    }
}



?>