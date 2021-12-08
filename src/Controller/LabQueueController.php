<?php

namespace App\Controller;

use App\Message\LabAddMessage;
use App\Message\LabRemoveMessage;
use App\Message\LabUpdateMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class LabQueueController extends AbstractController
{
	private $bus_;

	public function __construct(MessageBusInterface $bus)
	{
		$this->bus_ = $bus;
	}

	/**
	 * @Route("/lab/dispatch", name="lab_queue_add", methods={"POST"})
	 */
	public function dispatchAddToQueue(Request $request): Response
	{
		$this->bus_->dispatch(new LabAddMessage(
			$request->request->get('name'),
			$request->request->get('mark'),
			$request->request->get('teacher_id'),
			$request->request->get('student_id')));

		return $this->json([
			'message' => 'Add Lab is send to queue',
		]);
	}

	/**
	 * @Route("/lab/dispatch", name="lab_queue_update", methods={"PUT"})
	 */
	public function dispatchUpdateToQueue(Request $request): Response
	{
		$this->bus_->dispatch(new LabUpdateMessage(
			$request->request->get('id'),
			$request->request->get('name'),
			$request->request->get('mark'),
			$request->request->get('teacher_id'),
			$request->request->get('student_id')));

		return $this->json([
			'message' => 'Update Lab is send to queue',
		]);
	}

	/**
	 * @Route("/lab/dispatch", name="lab_queue_remove", methods={"DELETE"})
	 */
	public function dispatchRemoveToQueue(Request $request): Response
	{
		$this->bus_->dispatch(new LabRemoveMessage(
			$request->request->get('id')));

		return $this->json([
			'message' => 'Remove Lab is send to queue',
		]);
	}
}
