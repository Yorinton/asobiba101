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
	
	public function __construct($date,$start_time,$end_time,Plan $plan,Options $options)
	{

		if(!$this->isAcceptableStartAndEndTime($start_time,$end_time,$plan)){
		    throw new \InvalidArgumentException('不正な開始時刻又は終了時刻が入力されています');
        }
        if(!$this->isAcceptableMaxTime($start_time,$end_time,$plan)){
            throw new \InvalidArgumentException('プランで指定された利用時間をオーバーしています');
        }
        if(!$this->notCleaningTime($plan,$start_time,$end_time)){
		    throw new \InvalidArgumentException('2or3時間パックの場合16時~17時以外で指定して下さい');
        }
		$this->date = $date;
		$this->start_time = $start_time;
		$this->end_time = $this->optimizeEndTime($options,$end_time);
	}


	private function isAcceptableStartAndEndTime($start_time,$end_time,$plan)
    {
        return $start_time >= AcceptableTime::acceptableStartTime($plan) && $end_time <= AcceptableTime::acceptableEndTime($plan);
    }

    private function isAcceptableMaxTime($start_time,$end_time,$plan)
    {
        if($plan->hasTwoHourPlan()){
            return $end_time - $start_time <= 2;
        }
        if($plan->hasThreeHourPlan()){
            return $end_time - $start_time <= 3;
        }
        return true;
    }

    private function optimizeEndTime($options,$end_time)
    {
        if($options->hasMidnightOption()){
            return 24;
        }
        if($options->hasStayOption()){
            return 9;
        }
        return $end_time;
    }

	public function getDate(): string
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

	public function notCleaningTime($plan,$start_time,$end_time):bool
	{
	    if($plan->hasShortTimePlan()) {
            return $start_time >= $this->cleaningTime['end'] || $end_time <= $this->cleaningTime['start'];
        }
        return true;
	}

}