<?php

namespace App\MessageHandler;

use App\Message\LabRemoveMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Lab;
use Doctrine\ORM\EntityManagerInterface;

class LabRemoveHandler implements MessageHandlerInterface
{
	private $entityManager_;

	public function __construct(EntityManagerInterface $manager)
	{
		$this->entityManager_ = $manager;
	}

	public function __invoke(LabRemoveMessage $labMessage)
	{
		$lab = $this->entityManager_->getRepository(Lab::class)->find($labMessage->getId());

		$this->entityManager_->remove($lab);

		$this->entityManager_->persist($lab);
		$this->entityManager_->flush();
	}

}