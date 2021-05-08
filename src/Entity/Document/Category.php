<?php

namespace App\Entity\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="document_categories")
 */
class Category  {

    const CODE_MAIN_MENU = 'main-menu';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * Jednoznacny kod kategorie (nie je povinny)
     * @ORM\Column(type="string", length=50, nullable=true, unique=true)
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $description;

    /**
     * Zoznam dokumentov, patriacich do kategorie
     * Pokial bude vymazana kategoria, vymazu sa aj vsetky dokumenty v nej (cascade={"remove"})
     * @ORM\OneToMany(targetEntity="Document", mappedBy="category", cascade={"all"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $documents;

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
     * @return Document[]
     */
    public function getDocuments() {
        return $this->documents;
    }

    /**
     * @param Document[] $documents
     */
    public function setDocuments($documents) {
        $this->documents = $documents;
    }

    /**
     * Zoznam pokdategorii
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * Rodicovska kategoria
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children", cascade={"all"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $parent;

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
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @param ArrayCollection $children
     */
    public function setChildren($children) {
        $this->children = $children;
    }

    /**
     * @return Category
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function __construct() {
        $this->children = new ArrayCollection();
    }

    public function __toString() {
        return $this->name;
    }

    public function getFullName() {
        $name = $this->name;
        $category = $this;
        while ($category = $category->getParent()) {
            $name = $category->getName() . ' / ' . $name;
        }

        return $name;
    }

}