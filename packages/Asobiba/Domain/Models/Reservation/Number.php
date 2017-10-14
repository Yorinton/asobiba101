<?php

namespace Asobiba\Domain\Models\Reservation;

class Number
{

	private $number;

	public function __construct(Int $number,Plan $plan)
	{
		if(!isAcceptableNumber($number,$plan)){
			throw new \InvalidArgumentException('適切な利用人数を設定して下さい');
		}
		$this->number = $number;
	}

	public function isAcceptableNumber(Int $number,Plan $plan): boolean
	{
		if ($number > $plan->capacity) {
			return false;
		}
		return true;
	}

}


?>