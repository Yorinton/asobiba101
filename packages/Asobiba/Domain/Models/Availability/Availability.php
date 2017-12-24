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
        $startDateTime = $this->toDatetimeFormat($reservation->getdate()->getDate(),$reservation->getdate()->getStartTime());
        $endDateTime = $this->toDatetimeFormat($reservation->getdate()->getDate(),$reservation->getDate()->getEndTime());

        if($this->calendar->isBusy($startDateTime,$endDateTime)){
            //独自例外に変更
            throw new \InvalidArgumentException('ご希望の時間帯は別の方が予約済みです');
        }
        return true;
    }

    //予約追加の成否をbooleanで返す
    public function keepDate(Reservation $reservation): bool
    {

        $startDateTime = $this->toDatetimeFormat($reservation->getdate()->getDate(),$reservation->getdate()->getStartTime());
        $endDateTime = $this->toDatetimeFormat($reservation->getdate()->getDate(),$reservation->getDate()->getEndTime());
        $summary = '仮押さえ(自)';

        if(!$this->calendar->createEvent($startDateTime,$endDateTime,$summary)){
            //独自例外に変更
            throw new \UnexpectedValueException('日程の確保に失敗しました');
        }
        return true;
    }

    //Reservationから抽出した日程をフォーマット
    private function toDatetimeFormat(string $date,int $hour)
    {

        $date = $hour === 9 ? date('Y-m-d',strtotime($date.'+ 1 day')) : $date;

        $dateArr = explode('-',$date);
        $year = $dateArr[0];
        $month = $dateArr[1];
        $day = $dateArr[2];

        $datetime = date('c',mktime($hour,0,0,$month,$day,$year));

        return $datetime;
    }

}
