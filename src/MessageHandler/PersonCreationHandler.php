<?php

namespace App\MessageHandler;

use App\Message\PersonAddMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;

class PersonCreationHandler implements MessageHandlerInterface
{
	private $entityManager_;

	public function __construct(EntityManagerInterface $manager)
	{
		$this->entityManager_ = $manager;
	}

	public function __invoke(PersonAddMessage $personMessage)
	{
		$person = new Person();
		$person->setFirstName($personMessage->getFirstName());
		$person->setSecondName($personMessage->getSecondName());
		$person->setGender($personMessage->getGender());

		$this->entityManager_->persist($person);
		$this->entityManager_->flush();
	}

}