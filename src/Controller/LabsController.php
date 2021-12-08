<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Lab;
use App\Entity\Person;

class LabsController extends AbstractController
{
	/**
	 * @Route("/labs", name="get_labs", methods={"GET"})
	 */
	public function index(): Response
	{
		$labs = $this->getDoctrine()->getRepository(Lab::class)->findAll();

		$labs_arr = [];

		foreach ($labs as $lab) {
			$teacher = ['id' => $lab->getTeacher()->getId(),
				'first_name' => $lab->getTeacher()->getFirstName(),
				'second_name' => $lab->getTeacher()->getSecondName()];

			$student = [
				'id' => $lab->getStudent()->getId(),
				'first_name' => $lab->getStudent()->getFirstName(),
				'second_name' => $lab->getStudent()->getSecondName()];

			$lab = [
				'id' => $lab->getId(),
				'name' => $lab->getName(),
				'mark' => $lab->getMark(),
				'teacher' => $teacher,
				'student' => $student];
			array_push($labs_arr, $lab);
		}

		return $this->json($labs_arr, Response::HTTP_OK);
	}

	/**
	 * @Route("/labs", name="create_lab", methods={"POST"})
	 */
	public function create(Request $request): Response
	{
		if (!$request->request->get('name')) {
			return $this->json(['message' => 'field \'name\' is required.'], Response::HTTP_BAD_REQUEST);
		}

		if (!$request->request->get('mark')) {
			return $this->json(['message' => 'field \'mark\' is required.'], Response::HTTP_BAD_REQUEST);
		}

		if (!$request->request->get('teacher_id')) {
			return $this->json(['message' => 'field \'teacher_id\' is required.'], Response::HTTP_BAD_REQUEST);
		}

		if (!$request->request->get('student_id')) {
			return $this->json(['message' => 'field \'student_id\' is required.'], Response::HTTP_BAD_REQUEST);
		}

		$entityManager = $this->getDoctrine()->getManager();
		$persons = $this->getDoctrine()->getRepository(Person::class);

		$student = $persons->find($request->get('student_id'));
		if ($student == null) {
			return $this->json(['message' => 'student with given id is not found.'], Response::HTTP_BAD_REQUEST);
		}

		$teacher = $persons->find($request->get('teacher_id'));
		if ($teacher == null) {
			return $this->json(['message' => 'teacher with given id is not found.'], Response::HTTP_BAD_REQUEST);
		}

		$lab = new Lab();
		$lab->setName($request->request->get('name'));
		$lab->setMark($request->get('mark'));
		$lab->setStudent($student);
		$lab->setTeacher($teacher);

		$entityManager->persist($lab);
		$entityManager->flush();

		return $this->json([
			'id' => $lab->getId(),
			'name' => $lab->getName(),
			'mark' => $lab->getMark(),
			'teacher_id' => $lab->getTeacher()->getId(),
			'student_id' => $lab->getStudent()->getId()
		], Response::HTTP_CREATED);
	}

	/**
	 * @Route("/labs/{id}", name="update_lab", methods={"PUT"})
	 */
	public function update(int $id, Request $request): Response
	{
		$lab = $this->getDoctrine()->getRepository(Lab::class)->find($id);

		if (!$lab) {
			return $this->json(["message" => "Object with given attributes does not exist"], Response::HTTP_BAD_REQUEST);
		}

		$decodedRequest = json_decode($request->getContent());

		/* $student = $this->getDoctrine()->getRepository(Person::class)->find($decodedRequest->student_id);

		if (!$student) {
			return $this->json(["message" => "Can not fine student with given id"], Response::HTTP_BAD_REQUEST);
		}

		$teacher = $this->getDoctrine()->getRepository(Person::class)->find($decodedRequest->teacher_id);

		if (!$teacher) {
			return $this->json(["message" => "Can not fine teacher with given id"], Response::HTTP_BAD_REQUEST);
		}

		*/

		// $lab->setStudent($student);
		// $lab->setTeacher($teacher);
		// $lab->setName($decodedRequest->name);
		// $lab->setMark($decodedRequest->mark);

		$this->getDoctrine()->getManager()->flush();

		return $this->json(['id' => $lab->getId(),
			'name' => 'Hello_world',
			'mark' => $lab->getMark(),
			'teacher_id' => $lab->getTeacher()->getId(),
			'student_id' => $lab->getStudent()->getId()], Response::HTTP_OK);
	}

	/**
	 * @Route("/labs/{id}", name="delete_lab", methods={"DELETE"})
	 */
	public function remove(int $id): Response
	{
		$lab = $this->getDoctrine()->getRepository(Lab::class)->find($id);

		if ($lab == null) {
			return $this->json(["message" => "Object with given attributes does not exist"], Response::HTTP_BAD_REQUEST);
		}

		$this->getDoctrine()->getManager()->remove($lab);
		$this->getDoctrine()->getManager()->flush();

		return $this->json([], Response::HTTP_NO_CONTENT);
	}
}
