<?php

namespace Asobiba\Domain\Models\Reservation;


class DateOfUse
{

	private $date;

	private $start_time;

	private $end_time;

	private $cleaningTime = [
		'start' => 16,
		'end' => 17,
	];
	
	public function __construct($date,$start_time,$end_time)
	{
		if(!$this->isAvailable($date,$start_time,$end_time)){
			throw new \InvalidArgumentException('ご希望の時間帯は別の方が予約済みです');
		}
		$this->date = $date;
		$this->start_time = $start_time;
		$this->end_time = $end_time;
	}

	private function isAvailable($date,$start_time,$end_time)
	{
		//Googleカレンダーに問い合わせる
		return true;
	}

	public function getDateOfUse(): string
	{
		return $this->date;
	}

	public function getStartTime():int
	{
		return $this->start_time;
	}

	public function getEndTime():int
	{
		return $this->end_time;
	}

	public function notCleaningTime():bool
	{
		return $this->getStartTime() >= $this->cleaningTime['end'] || $this->getEndTime() <= $this->cleaningTime['start'];
	}

}

?>