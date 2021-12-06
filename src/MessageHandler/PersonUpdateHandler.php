<?php

namespace App\MessageHandler;

use App\Message\PersonUpdateMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;

class PersonUpdateHandler implements MessageHandlerInterface
{
	private $entityManager_;

	public function __construct(EntityManagerInterface $manager)
	{
		$this->entityManager_ = $manager;
	}

	public function __invoke(PersonUpdateMessage $personMessage)
	{
		$person = $this->entityManager_->getRepository(Person::class)->find($personMessage->getId());

		$person->setFirstName($personMessage->getFirstName());
		$person->setSecondName($personMessage->getSecondName());
		$person->setGender($personMessage->getGender());

		$this->entityManager_->persist($person);
		$this->entityManager_->flush();
	}

}