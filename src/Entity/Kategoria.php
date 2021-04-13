<?php

namespace App\Entity;

use App\Repository\KategoriaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KategoriaRepository::class)
 */
class Kategoria
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nazov;


    private $polozky;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazov(): ?string
    {
        return $this->nazov;
    }

    public function setNazov(string $nazov): self
    {
        $this->nazov = $nazov;

        return $this;
    }

    public function getPolozky(): ?string
    {
        return $this->polozky;
    }

    public function setPolozky(string $polozky): self
    {
        $this->polozky = $polozky;

        return $this;
    }
}
