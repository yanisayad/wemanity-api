<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cinema")
 * @ORM\Entity(repositoryClass="App\Repository\CinemaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Cinema
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="cinemas")
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movie", mappedBy="cinema")
     */
    private $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getMovies()
    {
        return array_map(function ($movie) {
            return $movie->toArray();
        }, $this->movies->toArray());
    }

    /**
     * return Entity as Array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id"     => $this->getId(),
            "name"   => $this->getName(),
            "street" => $this->getStreet(),
            "phone"  => $this->getPhone(),
        ];
    }
}
