<?php

namespace Asobiba\Domain\Models\User;

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

	public function getId(): CustomerId
    {
        return $this->id;
    }

	public function getName(): CustomerName
	{
		return $this->name;
	}

	public function getEmail(): CustomerEmail
	{
		return $this->email;
	}
}
