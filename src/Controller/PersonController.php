<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Person;
use App\Message\PersonMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class PersonController extends AbstractController
{
	/**
	 * @Route("/person", name="person", methods={"GET"})
	 */
	public function index(): Response
	{
		$persons = $this->getDoctrine()->getRepository(Person::class)->findAll();

		$persons_arr = [];

		foreach ($persons as $person) {
			$array_record = ['first_name' => $person->getFirstName(), 'second_name' => $person->getSecondName(), 'gender' => $person->getGender()];
			array_push($persons_arr, $array_record);
		}

		return $this->json($persons_arr, Response::HTTP_OK);
	}

	/**
	 * @Route("/person", methods={"POST"})
	 */
	public function create(Request $request): Response
	{
		if (!$request->request->get('first_name')) {
			return $this->json(['message' => 'field \'first_name\' is required.'], Response::HTTP_BAD_REQUEST);
		}

		if (!$request->request->get('second_name')) {
			return $this->json(['message' => 'field \'second_name\' is required.'], Response::HTTP_BAD_REQUEST);
		}

		if (!$request->request->get('gender')) {
			return $this->json(['message' => 'field \'gender\' is required.'], Response::HTTP_BAD_REQUEST);
		}

		$new_person = new Person();
		$new_person->setFirstName($request->request->get('first_name'));
		$new_person->setSecondName($request->request->get('second_name'));
		$new_person->setGender($request->request->get('gender'));

		$personManager = $this->getDoctrine()->getManager();
		$personManager->persist($new_person);
		$personManager->flush();

		return $this->json([
			'id' => $new_person->getId(),
			'first_name' => $new_person->getFirstName(),
			'second_name' => $new_person->getSecondName(),
			'gender' => $new_person->getGender()
 		], Response::HTTP_CREATED);
	}

	/**
	 * @Route("/person/{id}", methods={"PUT"})
	 */
	public function update(int $id, Request $request)
	{
		$person = $this->getDoctrine()->getRepository(Person::class)->find($id);

		if (!$person) {
			return $this->json(['message' => 'Can not find person with given id'], Response::HTTP_NOT_FOUND);
		}

		if ($request->request->get('first_name')) {
			$person->setFirstName($request->request->get('first_name'));
		}

		if ($request->request->get('second_name')) {
			$person->setSecondName($request->request->get('second_name'));
		}

		if ($request->request->get('gender')) {
			$person->setGender($request->request->get('gender'));
		}

		$personManager = $this->getDoctrine()->getManager();
		$personManager->persist($person);
		$personManager->flush();

		return $this->json([
			'id' => $person->getId(),
			'first_name' => $person->getFirstName(),
			'second_name' => $person->getSecondName(),
			'gender' => $person->getGender()
		], Response::HTTP_OK);
	}

	/**
	 * @Route("/person/{id}", methods={"DELETE"})
	 */
	public function remove(int $id, Request $request)
	{
		$person = $this->getDoctrine()->getRepository(Person::class)->find($id);

		if (!$person) {
			return $this->json(['message' => 'Object with given attributes doesn\'t exist'], Response::HTTP_BAD_REQUEST);
		}

		$this->getDoctrine()->getManager()->remove($person);

		return $this->json([], Response::HTTP_NO_CONTENT);
	}

	/**
	 * @Route("/dispatch", methods={"POST"})
	 */
	public function sendToQueue(MessageBusInterface $bus): Response
	{
		$bus->dispatch(new PersonMessage("Hello", "World", "Some"));

		return $this->json([], Response::HTTP_OK);
	}


}
