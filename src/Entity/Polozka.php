<?php

namespace App\Entity;

use App\Repository\PolozkaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PolozkaRepository::class)
 */
class Polozka
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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $opis;

    /**
     * @ORM\Column(type="float")
     */
    private $cena;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $obrazok;

    /**
     * @ORM\ManyToMany(targetEntity="Kategoria")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    private $kategoria;

    public function __construct()
    {
        $this->kategoria = new ArrayCollection();
    }

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

    public function getOpis(): ?string
    {
        return $this->opis;
    }

    public function setOpis(string $opis): self
    {
        $this->opis = $opis;

        return $this;
    }

    public function getCena(): ?float
    {
        return $this->cena;
    }

    public function setCena(float $cena): self
    {
        $this->cena = $cena;

        return $this;
    }

    public function getObrazok(): ?string
    {
        return $this->obrazok;
    }

    public function setObrazok(?string $obrazok): self
    {
        $this->obrazok = $obrazok;

        return $this;
    }

    public function getKategoria(): ?string
    {
        return $this->kategoria;
    }

    public function setKategoria(string $kategoria): self
    {
        $this->kategoria = $kategoria;

        return $this;
    }

    public function addKategorium(Kategoria $kategorium): self
    {
        if (!$this->kategoria->contains($kategorium)) {
            $this->kategoria[] = $kategorium;
        }

        return $this;
    }

    public function removeKategorium(Kategoria $kategorium): self
    {
        $this->kategoria->removeElement($kategorium);

        return $this;
    }
}
