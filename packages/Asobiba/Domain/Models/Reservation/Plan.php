<?php

namespace Asobiba\Domain\Models\Reservation;

use Asobiba\Domain\Models\Enum;

final class Plan extends Enum
{
    /** @var String */
//	protected $value;

    protected const ENUM = [

        '【非商用】基本プラン(平日)' => '【非商用】基本プラン(平日)',
        '【非商用】基本プラン(休日)' => '【非商用】基本プラン(休日)',
        '【非商用】お昼5時間パック' => '【非商用】お昼5時間パック',
        '【非商用】夜5時間パック' => '【非商用】夜5時間パック',
        '【商用】基本１日プラン' => '【商用】基本１日プラン',
        '【商用】お昼5時間パック' => '【商用】お昼5時間パック',
        '【商用】夜5時間パック' => '【商用】夜5時間パック',
        '【商用】3時間パック' => '【商用】3時間パック',
        '【商用】2時間パック' => '【商用】2時間パック',
    ];
    //ここではプランコード(アスキー)だけ持たせて、表示するプラン名はViewに近いところで変換する
    //DBに登録するときもプランコード

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


    /**
     * @return String
     */
    public function getPlan(): String
    {
        return $this->value;
    }

    public function getPrice(): int
    {
        return $this::PriceOfPlanSet[$this->value];
    }

    public function hasShortTimePlan(): bool
    {
        return strpos($this->value, '2時間') || strpos($this->value, '3時間');
    }

    public function hasTwoHourPlan()
    {
        return strpos($this->value, '2時間');
    }

    public function hasThreeHourPlan()
    {
        return strpos($this->value, '3時間');
    }

    public function hasDayTimePlan()
    {
        return strpos($this->value, '昼');
    }


}


?>