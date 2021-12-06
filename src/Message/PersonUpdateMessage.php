<?php

namespace App\Message;

class PersonUpdateMessage
{
	private $id;
	private $firstName;
	private $secondName;
	private $gender;

	public function __construct(int $id, string $firstName, string $secondName, string $gender)
	{
		$this->id = $id;
		$this->firstName = $firstName;
		$this->secondName = $secondName;
		$this->gender = $gender;
	}

	public function getId(): int
	{
		return $this->id;
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