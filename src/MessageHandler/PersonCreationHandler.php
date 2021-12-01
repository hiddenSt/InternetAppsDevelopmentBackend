<?php

namespace App\MessageHandler;

use App\Message\PersonMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PersonCreationHandler implements MessageHandlerInterface
{
	public function __invoke(PersonMessage $message)
	{

	}

}