<?php

namespace App\Controller;

use App\Message\PersonAddMessage;
use App\Message\PersonRemoveMessage;
use App\Message\PersonUpdateMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class PersonQueueController extends AbstractController
{
	private $bus_;

	public function __construct(MessageBusInterface $bus)
	{
		$this->bus_ = $bus;
	}

	/**
	 * @Route("/person/dispatch", name="person_queue_add", methods={"POST"})
	 */
	public function dispatchAddToQueue(Request $request): Response
	{
		$this->bus_->dispatch(new PersonAddMessage(
			$request->request->get('first_name'),
			$request->request->get('second_name'),
			$request->request->get('gender')));

		return $this->json([
			'message' => 'Add Person is send to queue',
		]);
	}

	/**
	 * @Route("/person/dispatch", name="person_queue_update", methods={"PUT"})
	 */
	public function dispatchUpdateToQueue(Request $request): Response
	{
		$this->bus_->dispatch(new PersonUpdateMessage(
			$request->request->get('id'),
			$request->request->get('first_name'),
			$request->request->get('second_name'),
			$request->request->get('gender')));

		return $this->json([
			'message' => 'Update Person is send to queue',
		]);
	}

	/**
	 * @Route("/person/dispatch/{id}", name="person_queue_remove", methods={"DELETE"})
	 */
	public function dispatchRemoveToQueue(int $id): Response
	{
		$this->bus_->dispatch(new PersonRemoveMessage($id));

		return $this->json([
			'message' => 'Remove Person is send to queue',
		]);
	}
}
