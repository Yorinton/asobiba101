<?php

namespace Asobiba\Domain\Models\User;

/**
* 
*/
class Customer
{
	private $id;

	private $name;

	private $email;

	public function __construct(CustomerId $id,CustomerName $name,CustomerEmail $email)
	{
	    $this->id = $id;
		$this->name = $name;
		$this->email = $email;	
	}

	public function getId(): int
    {
        return $this->id->getId();
    }

	public function getName():string
	{
		return $this->name->getName();
	}

	public function getEmail():string
	{
		return $this->email->getEmail();
	}
}

?>