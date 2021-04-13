<?php

namespace App\Entity;

use App\Repository\ObjednavkaRepository;
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
    private $casVytvorenia;

    /**
     * @ORM\Column(type="datetime")
     */
    private $casOdoslania;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $stavObjednavky;

    /**
     * @ORM\OneToMany(targetEntity="Polozka", mappedBy="id")
     */
    private $zoznamPoloziek;

    /**
     * @ORM\ManyToOne(targetEntity="Pouzivatel")
     */
    private $pouzivatel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCasVytvorenia(): ?\DateTimeInterface
    {
        return $this->casVytvorenia;
    }

    public function setCasVytvorenia(\DateTimeInterface $casVytvorenia): self
    {
        $this->casVytvorenia = $casVytvorenia;

        return $this;
    }

    public function getCasOdoslania(): ?\DateTimeInterface
    {
        return $this->casOdoslania;
    }

    public function setCasOdoslania(\DateTimeInterface $casOdoslania): self
    {
        $this->casOdoslania = $casOdoslania;

        return $this;
    }

    public function getStavObjednavky(): ?string
    {
        return $this->stavObjednavky;
    }

    public function setStavObjednavky(string $stavObjednavky): self
    {
        $this->stavObjednavky = $stavObjednavky;

        return $this;
    }

    public function getZoznamPoloziek(): ?string
    {
        return $this->zoznamPoloziek;
    }

    public function setZoznamPoloziek(string $zoznamPoloziek): self
    {
        $this->zoznamPoloziek = $zoznamPoloziek;

        return $this;
    }

    public function getPouzivatel(): ?string
    {
        return $this->pouzivatel;
    }

    public function setPouzivatel(string $pouzivatel): self
    {
        $this->pouzivatel = $pouzivatel;

        return $this;
    }
}
