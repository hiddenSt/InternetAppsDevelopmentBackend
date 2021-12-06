<?php

namespace App\Message;

class LabUpdateMessage
{
	private $id;
	private $name;
	private $mark;
	private $teacher_id;
	private $student_id;

	public function __construct(int $id, string $name, string $mark, int $teacher_id, int $student_id)
	{
		$this->id = $id;
		$this->name = $name;
		$this->mark = $mark;
		$this->teacher_id = $teacher_id;
		$this->student_id = $student_id;
	}

	public function getId(): int
	{
		return $this->id;
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