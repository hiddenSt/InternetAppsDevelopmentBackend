<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Person;

class PersonController extends AbstractController
{
	/**
	 * @Route("/person", name="person", methods={"GET"})
	 */
	public function index(): Response
	{
		$persons = $this->getDoctrine()->getRepository(Person::class)->findAll();

		return $this->json($persons, Response::HTTP_OK);
	}

	/**
	 * @Route("/person", methods={"POST"})
	 */
	public function create(Request $request): Response
	{
		$personManager = $this->getDoctrine()->getManager();

		$new_person = new Person();
		$new_person->setFirstName($request->request->get('firstName'));
		$new_person->setSecondName($request->request->get('secondName'));
		$new_person->setGender($request->request->get('gender'));

		$personManager->persist($new_person);
		$personManager->flush();
		return $this->json($request);
	}

	/**
	 * @Route("/person/{id}", methods={"PUT"})
	 */
	public function update(int $id, Request $request)
	{

	}

	/**
	 * @Route("/person/{id}", methods={"DELETE"})
	 */
	public function remove(int $id, Request $request)
	{
		$person = $this->getDoctrine()->getRepository(Person::class)->find($id);

		if ($person == null)  {
			return $this->json(["message" => "Object with given attributes doesn't exist"], Response::HTTP_BAD_REQUEST);

		}

		$this->getDoctrine()->getManager()->remove($person);

		return $this->json([], Response::HTTP_NO_CONTENT);
	}

}
