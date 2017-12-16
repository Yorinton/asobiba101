<?php

namespace Asobiba\Domain\Availability;

use Asobiba\Domain\Models\Calendar\CalendarInterface;
use Asobiba\Domain\Models\Reservation\Reservation;

class Availability
{

    private $calendar;

    public function __construct(CalendarInterface $calendar)
    {
        $this->calendar = $calendar;
    }


    /**
     * 空き状況チェック
     * @return bool
     */
    public function isAvailable(Reservation $reservation): bool
    {
        //$reservationから日程、時間を抽出
        $date = $reservation->getdate()->getDate();
        $start = $reservation->getdate()->getStartTime();
        $end = $reservation->getDate()->getEndTime();

        if($this->calendar->isEvent($date,$start,$end)){
            //独自例外に変更
            throw new \InvalidArgumentException('ご希望の時間帯は別の方が予約済みです');
        }
        return true;
    }

    //予約追加の成否をbooleanで返す
    public function keepDate(Reservation $reservation): bool
    {
        //$reservationから日程、時間を抽出
        $date = $reservation->getdate()->getDate();
        $start = $reservation->getdate()->getStartTime();
        $end = $reservation->getDate()->getEndTime();

        if(!$this->calendar->createEvent($date,$start,$end)){
            //独自例外に変更
            throw new \UnexpectedValueException('日程の確保に失敗しました');
        }
        return true;
    }

}
