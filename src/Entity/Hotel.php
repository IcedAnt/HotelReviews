<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HotelRepository")
 */
class Hotel
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
	private $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $city;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $address;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="hotel_id")
	 */
	private $reviews;

	public function __construct()
	{
		$this->reviews = new ArrayCollection();
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getCity(): ?string
	{
		return $this->city;
	}

	public function setCity(string $city): self
	{
		$this->city = $city;

		return $this;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setAddress(string $address): self
	{
		$this->address = $address;

		return $this;
	}

	/**
	 * @return Collection|Review[]
	 */
	public function getReviews(): Collection
	{
		return $this->reviews;
	}

	public function addReview(Review $review): self
	{
		if (!$this->reviews->contains($review)) {
			$this->reviews[] = $review;
			$review->setHotelId($this);
		}

		return $this;
	}

	public function removeReview(Review $review): self
	{
		if ($this->reviews->contains($review)) {
			$this->reviews->removeElement($review);
			// set the owning side to null (unless already changed)
			if ($review->getHotelId() === $this) {
				$review->setHotelId(null);
			}
		}

		return $this;
	}
}
