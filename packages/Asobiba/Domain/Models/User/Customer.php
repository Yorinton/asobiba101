<?php

namespace Asobiba\Domain\Models\User;

class Customer
{
	private $name;

	private $email;

	public function __construct(string $name,string $email)
	{
	    if(!$this->isEmail($email)){
            throw new \InvalidArgumentException('not format of email is given');
        }
		$this->name = $name;
		$this->email = $email;	
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

    public function isEmail($email): bool
    {
        return strpos($email,'@');
    }
}
