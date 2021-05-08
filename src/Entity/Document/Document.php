<?php

namespace App\Entity\Document;

use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="documents")
 */
class Document {
    const CODE_INDEX_DOCUMENT = 'index';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=false)
     * @var string
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * Jedinečný kód pre identifikáciu dokumentu (nie je povinny)
     * @ORM\Column(type="string", length=50, nullable=true, unique=true)
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $published = false;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="documents")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * Poradie dokumentu v kategorii
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @Assert\PositiveOrZero
     * @var int
     */
    private $position = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $lastUpdate;

    /**
     * Je dokument publikovany (moze byt neaktivny)
     * @return bool
     */
    public function isPublished(): bool {
        return $this->published;
    }

    /**
     * @return string
     */
    public function getContent(): ?string {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(?string $content): void {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getCode(): ?string {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(?string $code): void {
        $this->code = $code;
    }

    /**
     * @param bool $published
     */
    public function setPublished(bool $published): void {
        $this->published = $published;
    }

    public function __construct() {
        $this->lastUpdate = new \DateTime();
    }

    /**
     * @return int
     */
    public function getPosition(): int {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void {
        $this->position = $position;
    }

    /**
     * @return Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void {
        $this->category = $category;
    }

    /**
     * Autor dokumentu
     * @ORM\ManyToOne(targetEntity="\App\Entity\User\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $author;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return User
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author) {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdate(): ?\DateTime {
        return $this->lastUpdate;
    }

    /**
     * Tato funkcia bude volana automaticky pred ulozenim objektu do DB (lifecycle callback)
     * @ORM\PreUpdate
     */
    public function updateLastUpdate(): void {
        $this->lastUpdate = new \DateTime();
    }


    public function __toString() {
        return $this->name;
    }
}