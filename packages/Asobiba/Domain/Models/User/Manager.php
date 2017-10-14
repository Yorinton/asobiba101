<?php

namespace Asobiba\Domain\Models\User;

/**
* 
*/
class Manager
{

	private $name = config('mail.from.name');

	private $email = config('mail.from.address');
	
	public function getManagerEmail()
	{
		return $this->email;
	}
}


?>