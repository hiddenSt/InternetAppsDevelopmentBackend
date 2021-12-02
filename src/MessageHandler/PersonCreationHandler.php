<?php

namespace App\MessageHandler;

use App\Message\PersonMessage;
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

	public function __invoke(PersonMessage $personMessage)
	{
		$personManager = $this->entityManager_->getRepository(Person::class);


	}

}