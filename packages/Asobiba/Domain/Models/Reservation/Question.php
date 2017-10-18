<?php

namespace Asobiba\Domain\Models\Reservation;


class Question
{
	
	private $question;

	public function __construct(String $question = null)
	{
		$this->question = $question;
	}

	public function isQuestion(): bool
	{
		return isset($this->question);
		// return $this->question !== '';
	}

	public function getQuestion(): String
	{
		return $this->question;
	}

}

?>