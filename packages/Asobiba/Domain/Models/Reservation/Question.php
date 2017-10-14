<?php

namespace Asobiba\Domain\Models\Reservation;

/**
* 
*/
class Question
{
	
	private $question;

	public function __construct(String $question)
	{
		$this->question = $question;
	}

	public function isQuestion(): boolean
	{
		return $this->question !== '';
	}


}

?>