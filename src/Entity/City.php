<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 * @ORM\HasLifecycleCallbacks
 */
class City
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
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cinema", mappedBy="city")
     */
    private $cinemas;

    public function __construct()
    {
        $this->cinemas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function getCinemas()
    {
        return array_map(function ($cinema) {
            return $cinema->toArray();
         }, $this->cinemas->toArray());
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function setDepartment(int $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * return Entity as Array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id"          => $this->getId(),
            "name"        => $this->getName(),
            "zipcode"     => $this->getZipcode(),
            "department"  => $this->getDepartment()
        ];
    }
}
