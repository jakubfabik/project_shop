<?php

namespace App\Entity;

use App\Repository\ObjednavkaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObjednavkaRepository::class)
 */
class Objednavka
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $cas_vytvorenia;

    /**
     * @ORM\Column(type="integer")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $cas_odoslania;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $stav_objednavky;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $zoznam_poloziek;



    public function __construct()
    {
        $this->zoznam_poloziek = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getcas_vytvorenia(): ?\DateTimeInterface
    {
        return $this->cas_vytvorenia;
    }

    public function setCasVytvorenia(\DateTimeInterface $cas_vytvorenia): self
    {
        $this->cas_vytvorenia = $cas_vytvorenia;

        return $this;
    }

    public function getcas_odoslania(): ?\DateTimeInterface
    {
        return $this->cas_odoslania;
    }

    public function setCasOdoslania(\DateTimeInterface $cas_odoslania): self
    {
        $this->cas_odoslania = $cas_odoslania;

        return $this;
    }

    public function getstav_objednavky(): ?string
    {
        return $this->stav_objednavky;
    }

    public function setStavObjednavky(string $stav_objednavky): self
    {
        $this->stav_objednavky = $stav_objednavky;

        return $this;
    }

    public function getzoznam_poloziek(): ?string
    {
        return $this->zoznam_poloziek;
    }

    public function setZoznamPoloziek(string $zoznam_poloziek): self
    {
        $this->zoznam_poloziek = $zoznam_poloziek;

        return $this;
    }

    public function getuser(): ?int
    {
        return $this->user;
    }

    public function setuser(int $user): self
    {
        $this->user = $user;

        return $this;
    }

}
