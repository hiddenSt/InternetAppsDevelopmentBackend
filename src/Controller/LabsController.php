<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Lab;

class LabsController extends AbstractController
{
    /**
     * @Route("/labs", methods={"GET"})
     */
    public function index(): Response
    {   
	$repository = $this->getDoctrine()->getRepository(Lab::class);
	$labs = $repository->findAll();
        return $this->json($labs);
    }
	
    /**
     * @Route("/labs", methods={"POST"}) 
     */
    public function create(Request $request): Response
    {
	$new_lab = new Lab();
	$new_lab->setName($request->request->get('name'));
        return $this->json($request);
    }
    
    /**
     * Route("/labs/{id}", methods={"PUT"})
     */    
    public function update($id, Request $request): Response
    {
	$manager = $this->getDoctrine()->getRespository(Labs::class);
	$lab = $manager->findOneBy(['id' => id]);
	$lab->setName($request->get('name'));
	$lab->setMark($request->get('mark'));
	$lab->setDeadline($request->get('deadline'));
	
	$manager->persist($lab);
	return $this->json($lab);
    }

    /**
     * Route("/labs/{id}", methods={"DELETE"})
     */
    public function remove($id): Response
    {
	$manager = $this->getDoctrine()->getReposutory(Lab::class);
	$lab = $manager->find(id);
	$manager->remove($lab);
	$manager->flush();
	return $this->json("Deleted");
    }
}
