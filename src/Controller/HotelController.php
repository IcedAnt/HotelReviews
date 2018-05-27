<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Hotel;

class HotelController extends Controller
{
	/**
	 * @Route("/hotel", name="hotel")
	 */
	public function index()
	{
		return $this->render ( 'hotel/index.html.twig', [ 'controller_name' => 'HotelController', ] );
	}

	/**
	 * @Route("/{name}/create")
	 */
	public function create ( $name )
	{
		$entityManager = $this->getDoctrine()->getManager();

		// Create new Hotel entry
		$hotel = new Hotel();
		$hotel->setName ( $name );
		$hotel->setCity ( 'Berlin' );
		$hotel->setAddress ( 'SomethingStraße' );

		// Save Hotel and run query
		$entityManager->persist ( $hotel );
		$entityManager->flush();

		return new Response ( 'Saved new hotel with id ' . $hotel->getId() );
	}
}
