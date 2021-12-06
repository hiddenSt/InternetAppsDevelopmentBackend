<?php

namespace App\MessageHandler;

use App\Message\PersonRemoveMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;

class PersonRemoveHandler implements MessageHandlerInterface
{
	private $entityManager_;

	public function __construct(EntityManagerInterface $manager)
	{
		$this->entityManager_ = $manager;
	}

	public function __invoke(PersonRemoveMessage $personMessage)
	{
		$person = $this->entityManager_->getRepository(Person::class)->find($personMessage->getId());

		$this->entityManager_->remove($person);

		$this->entityManager_->persist($person);
		$this->entityManager_->flush();
	}

}