<?php
/**
 * Neviem co s ID. Ci sa vratit k ciselnemu ID alebo to nechat takto.
 */
namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_roles")
 */
class Role {
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="string", unique=true, length=32)
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection|User[]
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     */
    private $users;

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
     * Role constructor.
     * @param string|null $name
     */
    public function __construct($name = 'ROLE_USER') {
        $this->id = $name;
        $this->users = new ArrayCollection();
    }

    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        if ($this->users->contains($user)) {
            return;
        }
        $this->users->add($user);
        $user->addRole($this);
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        if (!$this->users->contains($user)) {
            return;
        }
        $this->users->removeElement($user);
        $user->removeRole($this);
    }

    public function getId() {
        return $this->id;
    }

    public function setId(string $id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->id = $name;
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->id;
    }

    /**
     * Symfony ocakava, ze s rolou bude vediet pracovat ako s retazcom
     * @return string
     */
    public function getRole() {
        return $this->id;
    }
}