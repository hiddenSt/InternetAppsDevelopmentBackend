<?php

namespace App\Controller;

use App\Entity\Lab;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Notification implements MessageComponentInterface
{

	private $manager;
	private $clients;

	public function __construct(EntityManagerInterface $manager)
	{
		$this->manager = $manager;
		$this->clients = new \SplObjectStorage;
	}

	public function onOpen(ConnectionInterface $conn)
	{
		$this->clients->attach($conn);
	}

	public function onMessage(ConnectionInterface $from, $msg)
	{
		$decodedMessage = json_decode($msg);

		if ($decodedMessage->object_type == "Person") {
			$this->managePerson($decodedMessage, $from);
		} else if ($decodedMessage->object_type == "Lab") {
			$this->manageLab($decodedMessage, $from);
		}

	}

	public function onClose(ConnectionInterface $conn)
	{
		$this->clients->detach($conn);
	}

	public function onError(ConnectionInterface $conn, \Exception $e)
	{
		$conn->close();
	}

	public function manageLab($msg, $from)
	{
		if ($msg->operation == "add") {
			$lab = new Lab;

			$student = $this->manager->getRepository(Person::class)->find($msg->student_id);
			$teacher = $this->manager->getRepository(Person::class)->find($msg->teacher_id);

			if (!$student) {
				$message = ['error' => 'student with given id does not exist'];
				$from->send(json_encode($message));
			}

			if (!$teacher) {
				$message = ['error' => 'teacher with given id does not exist'];
				$from->send(json_encode($message));
			}

			$lab->setName($msg->name);
			$lab->setMark($msg->mark);
			$lab->setTeacher($teacher);
			$lab->setStudent($student);

			$this->manager->persist($lab);
			$this->manager->flush();

			$studentMessage = [
				'id' => $student->getId(),
				'first_name' => $student->getFirstName(),
				'second_name' => $student->getSecondName(),
				'gender' => $student->getGender()
			];

			$teacherMessage = [
				'id' => $student->getId(),
				'first_name' => $student->getFirstName(),
				'second_name' => $student->getSecondName(),
				'gender' => $student->getGender()
			];

			$message = [
				'id' => $lab->getId(),
				'name' => $lab->getName(),
				'mark' => $lab->getMark(),
				'student' => $studentMessage,
				'teacher' => $teacherMessage
			];

			$from->send(json_encode($message));

		} else if ($msg->operation == "update") {
			$lab = $this->manager->getRepository(Lab::class)->find($msg->id);

			if (!$lab) {
				$message = ['error' => 'lab with given id does not exist'];
				$from->send(json_encode($message));
				return;
			}

			$student = $this->manager->getRepository(Person::class)->find($msg->student_id);
			$teacher = $this->manager->getRepository(Person::class)->find($msg->teacher_id);

			if (!$student) {
				$message = ['error' => 'student with given id does not exist'];
				$from->send(json_encode($message));
			}

			if (!$teacher) {
				$message = ['error' => 'teacher with given id does not exist'];
				$from->send(json_encode($message));
			}

			$lab->setName($msg->name);
			$lab->setMark($msg->mark);
			$lab->setTeacher($teacher);
			$lab->setStudent($student);

			$this->manager->persist($lab);
			$this->manager->flush();

			$studentMessage = [
				'id' => $student->getId(),
				'first_name' => $student->getFirstName(),
				'second_name' => $student->getSecondName(),
				'gender' => $student->getGender()
			];

			$teacherMessage = [
				'id' => $student->getId(),
				'first_name' => $student->getFirstName(),
				'second_name' => $student->getSecondName(),
				'gender' => $student->getGender()
			];

			$message = [
				'id' => $lab->getId(),
				'name' => $lab->getName(),
				'mark' => $lab->getMark(),
				'student' => $studentMessage,
				'teacher' => $teacherMessage
			];

			$from->send(json_encode($message));
		} else if ($msg->operation == "remove") {
			$lab = $this->manager->getRepository(Lab::class)->find($msg->id);

			if (!$lab) {
				$message = ['error' => 'lab with given id does not exist'];
				$from->send(json_encode($message));
				return;
			}

			$this->manager->remove($lab);
			$this->manager->flush();
		}
	}

	public function managePerson($msg, $from)
	{
		if ($msg->operation == "add") {
			$person = new Person;

			$person->setFirstName($msg->first_name);
			$person->setSecondName($msg->second_name);
			$person->setGender($msg->gender);

			$this->manager->persist($person);
			$this->manager->flush();

			$message = [
				'id' => $person->getId(),
				'first_name' => $person->getFirstName(),
				'second_name' => $person->getSecondName(),
				'gender' => $person->getGender()];

			$from->send(json_encode($message));

		} else if ($msg->operation == "update") {
			$person = $this->manager->getRepository(Person::class)->find($msg->id);

			if (!$person) {
				$message = ['error' => 'person with given id does not exist'];
				$from->send(json_encode($message));
				return;
			}

			$person->setFirstName($msg->first_name);
			$person->setSecondName($msg->second_name);
			$person->setGender($msg->gender);

			$this->manager->persist($person);
			$this->manager->flush();

			$message = [
				'id' => $person->getId(),
				'first_name' => $person->getFirstName(),
				'second_name' => $person->getSecondName(),
				'gender' => $person->getGender()];

			$from->send(json_encode($message));
		} else if ($msg->operation == "remove") {
			$person = $this->manager->getRepository(Person::class)->find($msg->id);

			if (!$person) {
				$message = ['error' => 'person with given id does not exist'];
				$from->send(json_encode($message));
				return;
			}


			$this->manager->remove($person);
			$this->manager->flush();
		}
	}
}



