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

	public function getFirstName(): string
	{
		return $this->firstName;
	}

	public function getSecondName(): string
	{
		return $this->secondName;
	}

	public function getGender(): string
	{
		return $this->gender;
	}

}
