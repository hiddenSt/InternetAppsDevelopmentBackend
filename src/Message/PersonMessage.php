<?php

namespace App\Message;

class PersonMessage
{
	private $firstName;
	private $secondName;
	private $gender;
	

	public function __construct(int $personId)
	{
		$this->personId = $personId;
	}

	public function getPersonId(): int
	{
		return $this->personId;
	}

}
