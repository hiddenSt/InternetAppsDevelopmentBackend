<?php

namespace App\MessageHandler;

use App\Message\LabUpdateMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Lab;
use Doctrine\ORM\EntityManagerInterface;

class LabUpdateHandler implements MessageHandlerInterface
{
	private $entityManager_;

	public function __construct(EntityManagerInterface $manager)
	{
		$this->entityManager_ = $manager;
	}

	public function __invoke(LabUpdateMessage $labMessage)
	{
		$lab = $this->entityManager_->getRepository(Lab::class)->find($labMessage->getId());

		$lab->setName($labMessage->getName());
		$lab->setMark($labMessage->getMark());
	}

}