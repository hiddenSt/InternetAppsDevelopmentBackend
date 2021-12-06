<?php

namespace App\MessageHandler;

use App\Entity\Person;
use App\Message\LabAddMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Lab;
use Doctrine\ORM\EntityManagerInterface;

class LabCreationHandler implements MessageHandlerInterface
{
	private $entityManager_;

	public function __construct(EntityManagerInterface $manager)
	{
		$this->entityManager_ = $manager;
	}

	public function __invoke(LabAddMessage $labMessage)
	{
		$teacher = $this->entityManager_->getRepository(Person::class)->find($labMessage->getTeacherId());
		$student = $this->entityManager_->getRepository(Person::class)->find($labMessage->getStudentId());

		if (!$student || !$teacher) {
			// Then an error occurred
		}

		$lab = new Lab();
		$lab->setName($labMessage->getName());
		$lab->setMark($labMessage->getMark());
		$lab->setTeacher($teacher);
		$lab->setStudent($student);

		$this->entityManager_->persist($lab);
		$this->entityManager_->flush();
	}

}