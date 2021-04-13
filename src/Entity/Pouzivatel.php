<?php

namespace App\Entity;

use App\Repository\PouzivatelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PouzivatelRepository::class)
 */
class Pouzivatel
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
    private $meno;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $priezvisko;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresa;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $rola;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeno(): ?string
    {
        return $this->meno;
    }

    public function setMeno(string $meno): self
    {
        $this->meno = $meno;

        return $this;
    }

    public function getPriezvisko(): ?string
    {
        return $this->priezvisko;
    }

    public function setPriezvisko(string $priezvisko): self
    {
        $this->priezvisko = $priezvisko;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAdresa(): ?string
    {
        return $this->adresa;
    }

    public function setAdresa(string $adresa): self
    {
        $this->adresa = $adresa;

        return $this;
    }

    public function getRola(): ?string
    {
        return $this->rola;
    }

    public function setRola(string $rola): self
    {
        $this->rola = $rola;

        return $this;
    }
}
