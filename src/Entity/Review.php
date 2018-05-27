<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $text;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $user;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $rating;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="reviews")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $hotel;

	public function getId()
	{
		return $this->id;
	}

	public function getText(): ?string
	{
		return $this->text;
	}

	public function setText(string $text): self
	{
		$this->text = $text;

		return $this;
	}

	public function getUser(): ?string
	{
		return $this->user;
	}

	public function setUser(string $user): self
	{
		$this->user = $user;

		return $this;
	}

	public function getRating(): ?int
	{
		return $this->rating;
	}

	public function setRating(int $rating): self
	{
		$this->rating = $rating;

		return $this;
	}

	public function getHotel(): ?Hotel
	{
		return $this->hotel;
	}

	public function setHotel(?Hotel $hotel): self
	{
		$this->hotel = $hotel;

		return $this;
	}
}
