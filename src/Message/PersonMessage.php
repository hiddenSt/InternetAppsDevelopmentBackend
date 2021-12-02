<?php

namespace App\Message;

class PersonMessage
{
	private $firstName;
	private $secondName;
	private $gender;

	public function __construct(string $firstName, string $secondName, string $gender)
	{
		$this->firstName = $firstName;
		$this->secondName = $secondName;
		$this->gender = $gender;
	}


}
