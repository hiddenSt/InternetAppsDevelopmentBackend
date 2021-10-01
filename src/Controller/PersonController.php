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
        $repository = $this->getDoctrine()->getRepository(Person::class);
        $persons = $repository->findAll();
        return $this->json($persons);
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
	
	# $personManager->persist($new_person);
	return $this->json($request);
    }
}
