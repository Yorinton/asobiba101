<?php

namespace Asobiba\Domain\Models\Reservation;

class Capacity
{

    private $plan;

    private $options;

    private const capacityOfPlanSet = [

        '【非商用】基本プラン(平日)' => 11,
        '【非商用】基本プラン(休日)' => 11,
        '【非商用】お昼5時間パック' => 11,
        '【非商用】夜5時間パック' => 11,
        '【商用】基本１日プラン' => 15,
        '【商用】お昼5時間パック' => 15,
        '【商用】夜5時間パック' => 15,
        '【商用】3時間パック' => 15,
        '【商用】2時間パック' => 15,
    ];

    public function __construct(Plan $plan,Options $options)
    {
        $this->plan = $plan;
        $this->options = $options;
    }

    public function getCapacity()
    {
        if($this->options->hasLargeGroupOption()){
            return 15;
        }
        return self::capacityOfPlanSet[$this->plan->getPlan()];
    }

}