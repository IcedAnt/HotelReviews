<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Review;
use App\Entity\Hotel;

// use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class ReviewController extends Controller
{
	/**
	 * @Route("/review", name="review")
	 */
	public function index()
	{
		return $this->render ( 'review/index.html.twig', [ 'controller_name' => 'ReviewController', ] );
	}

	/**
	 * @Route("/{hotel_id}/today/review/")
	 */
	public function random ( $hotel_id )
	{
		// Check if hotel with $hotel_id exists
		$hotel = $this->getDoctrine()->getRepository ( Hotel::class )->find ( $hotel_id );

		// Throw exeption if not
		if ( !$hotel )
		{
			throw $this->createNotFoundException ( 'The hotel id ' . $hotel_id . ' was not found.' );
		}

		/* There's probably a better way to do this by using $hotel->getReviews() but run out of time */

		// Get DB connection
		$conn = $this->getDoctrine()->getEntityManager()->getConnection();

		$sql = 'SELECT * FROM review WHERE hotel_id = :hotel_id ORDER BY RAND() LIMIT 1';

		// Prepare and execute query
		$stmt = $conn->prepare ( $sql );
		$stmt->execute ( ['hotel_id' => $hotel_id] );

		// Fetch single result
		$result = $stmt->fetch();

		$review = $result['text'];

		// $cache = new FilesystemAdapter();
		// $cache->save ( $review );

		return new Response ( 'Check out this random review: ' . $review );
	}

	/**
	 * @Route("/{hotel_id}/review/")
	 */
	public function review ( Hotel $hotel_id )
	{
		$entityManager = $this->getDoctrine()->getManager();

		// Create new Review entry
		$review = new Review();
		$review->setText ( 'Never staying here again' );
		$review->setUser ( 'Anonymous' );
		$review->setRating ( 0 );
		$review->setHotel ( $hotel_id );

		// Save Hotel and run query
		$entityManager->persist ( $review );
		$entityManager->flush();

		return new Response ( 'Saved new review with id ' . $review->getId() );
	}
}
