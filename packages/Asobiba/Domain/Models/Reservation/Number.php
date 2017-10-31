<?php

namespace Asobiba\Domain\Models\Reservation;

class Number
{

	private $number;

	public function __construct(Int $number,Capacity $capacity)
	{
		if(!$this->isAcceptableNumber($number,$capacity)){
			throw new \InvalidArgumentException('適切な利用人数を設定して下さい');
		}
		$this->number = $number;
	}

	public function isAcceptableNumber(Int $number,Capacity $capacity): bool
	{
	    if($number > $capacity->getCapacity()){
            return false;
        }
		return true;
	}

    /**
     * @return Int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

}


?>