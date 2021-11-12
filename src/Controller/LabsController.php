<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Lab;

class LabsController extends AbstractController
{
	/**
	* @Route("/labs", name="get_labs", methods={"GET"})
	*/
	public function index(): Response
	{
		$labs = $this->getDoctrine()->getManager()->getRepository(Lab::class)->findAll();

		return $this->json($labs, Response::HTTP_OK);
	}

	/** 
	* @Route("/labs", name="create_lab", methods={"POST"})
	*/
	public function create(Request $request): Response
	{
		$entityManager = $this->getDoctrine()->getManager();

		$lab = new Lab();
		$lab->setName($request->request->get('name'));
		$lab->setMark($request->get('mark'));
		$lab->setStudent($request->get('student'));
		$lab->setTeacher($request->get('teacher'));

		$entityManager->persist($lab);
		$entityManager->flush();

		return $this->json($lab, Response::HTTP_CREATED);
	}

	/**
	* @Route("/labs/{id}", name="update_lab", methods={"PUT"})
	*/
	public function update(int $id, Request $request): Response
	{
		// TODO:
	}

	/**
	 * Route("/labs/{id}", name="delete_lab", methods={"DELETE"})
	 */
	public function remove(int $id, Request $request): Response
	{
		$lab = $this->getDoctrine()->getRepository(Lab::class)->find($id);

		if ($lab == null)  {
			return $this->json(["message" => "Object with given attributes doesn't exist"], Response::HTTP_BAD_REQUEST);

		}

		$this->getDoctrine()->getManager()->remove($lab);

		return $this->json([], Response::HTTP_NO_CONTENT);
	}
}
