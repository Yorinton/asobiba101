<?php

namespace Asobiba\Domain\Models\Reservation;


/**
* 
*/
class Date
{

	private $date;

	private $start_time;

	private $end_time;
	
	public function __construct($date,$start_time,$end_time)
	{
		if(!$this->isAcceptableStartTime($start_time)){
			return '利用時間は午前11時以降になります';
		}
		if(!$this->isAvailable($date,$start_time,$end_time)){
			return 'ご希望の時間は別の予約があるためご利用出来ません';
		}
		$this->date = $date;
		$this->start_time = $start_time;
		$this->end_time = $end_time;
	}

	private function isAvailable()
	{
		//Googleカレンダーに問い合わせる
	}

	private function calculateEndTime(Options $options)
	{
		if($options->hasStayOption()){
			return 9;
		}
		return (int)$this->end_time;
	}

	private function isAcceptableStartTime($start_time)
	{
		return $start_time >= 11;
	}

}

?>