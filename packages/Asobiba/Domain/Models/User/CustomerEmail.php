<?php

namespace Asobiba\Domain\Models\User;

class CustomerEmail
{
	
	public $email;

	public function __construct(string $email)
	{
	    if(!$this->isEmail($email)){
	        throw new \InvalidArgumentException('not format of email is given');
        }
		$this->email = $email;
	}

	public function getEmail():string
	{
		return $this->email;
	}

    /**
     * @param $email
     * @return bool
     */
    public function isEmail($email):bool
    {
        return strpos($email,'@');
    }
}
