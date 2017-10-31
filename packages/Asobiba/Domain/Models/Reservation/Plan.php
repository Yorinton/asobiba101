<?php

namespace Asobiba\Domain\Models\Reservation;

use Asobiba\Domain\Models\Enum;

final class Plan extends Enum
{
    /** @var String  */
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

    /**
     * @return String
     */
    public function getPlan(): String
    {
        return $this->value;
    }

    public function getPrice(): int
    {
        return PriceOfPlan::getPrice($this);
    }

	public function hasShortTimePlan():bool
	{
		return strpos($this->value,'2時間') || strpos($this->value,'3時間');
	}

    public function hasTwoHourPlan()
    {
        return strpos($this->value,'2時間');
    }
    public function hasThreeHourPlan()
    {
        return strpos($this->value,'3時間');
    }
    public function hasDayTimePlan()
    {
        return strpos($this->value,'昼');
    }


}


?>