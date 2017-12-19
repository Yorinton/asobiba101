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
        date_default_timezone_set('Asia/Tokyo');
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

        $dateArr = explode('-',$date);
        $year = $dateArr[0];
        $month = $dateArr[1];
        $day = $dateArr[2];

        $startDateTime = date('c',mktime($start,0,0,$month,$day,$year));
        $endDateTime = date('c',mktime($end,0,0,$month,$day,$year));
        $summary = '仮押さえ(自)';

        if(!$this->calendar->createEvent($startDateTime,$endDateTime,$summary)){
            //独自例外に変更
            throw new \UnexpectedValueException('日程の確保に失敗しました');
        }
        return true;
    }

}
