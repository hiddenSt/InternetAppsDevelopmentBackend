<?php

namespace App\Message;

class LabAddMessage
{
	private $name;
	private $mark;
	private $teacher_id;
	private $student_id;

	public function __construct(string $name, string $mark, int $teacher_id, int $student_id)
	{
		$this->name = $name;
		$this->mark = $mark;
		$this->teacher_id = $teacher_id;
		$this->student_id = $student_id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getMark(): string
	{
		return $this->mark;
	}

	public function getTeacherId(): string
	{
		return $this->teacher_id;
	}

	public function getStudentId(): string
	{
		return $this->student_id;
	}

}
