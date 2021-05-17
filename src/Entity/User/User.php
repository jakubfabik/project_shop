<?php
namespace App\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements UserInterface {
    /**
     * Ciselny identifikator pouzivatela
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * Prihlasovacie meno
     * @ORM\Column(type="string", unique=true, length=32)
     * @var string
     */
    private $username;

    /**
     * Krstne meno
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    private $firstName = '';

    /**
     * Priezvisko
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    private $surname = '';

    /**
     * Heslo
     * @ORM\Column(type="string", length=128)
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $plainPassword = '';

    /**
     * Mailova adresa
     * @ORM\Column(type="string", length=128)
     * Pomocou anotacii mozem napriklad definovat, ze atribut nesmie byt prazdny a musi mat format mailovej adresy
     * @Assert\NotBlank()
     * @Assert\Email()
     * @var string
     */
    private $email;

    /**
     * Zoznam rol pouzivatela
     * @var \Doctrine\Common\Collections\Collection|Role[]
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users",cascade={"persist"})
     * @ORM\JoinTable(name="user_role_rel",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    private $roles;

    /**
     * Konsruktor
     */
    public function __construct() {
        // v ramci konstruktora musime vytvorit instacie vsetkych atributov arraycollecion aby bolo  s nimi mozne pracovat
        $this->roles = new ArrayCollection();

    }

    /**
     * @return int
     */
    public function getIdmProfileId(): ?int {
        return $this->idmProfileId;
    }

    /**
     * @param int $idmProfileId
     */
    public function setIdmProfileId(int $idmProfileId): void {
        $this->idmProfileId = $idmProfileId;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getSurname(): ?string {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname) {
        $this->surname = $surname;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials() {
        $this->plainPassword = null;
    }

    /**
     * Ulozit hashovane! heslo, nie plain heslo!
     * V tejto podobe bude heslo ulozene do DB, nebude sa dalej spracovanat
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @param Role $role
     */
    public function addRole(Role $role)
    {
        if ($this->roles->contains($role)) {
            return;
        }
        $this->roles->add($role);
        $role->addUser($this);
    }

    /**
     * @param Role $role
     */
    public function removeRole(Role $role)
    {
        if (!$this->roles->contains($role)) {
            return;
        }
        $this->roles->removeElement($role);
        $role->removeUser($this);
    }

    public function getRoleObjects() {
        return $this->roles;
    }

    public function setRoleObjects($roles) {
        $this->roles = $roles;
    }

    /**
     * @return string[] The user roles
     */
    public function getRoles() {
        // aby bolo zabezpecene, ze user ma aspon jednu rolu, pre security firewall
        // toto sposobovalo problemy. Skusim sa spolahnut, ze rolu nezabudnem priradit
        if ($this->roles->count() == 0) {
            $this->roles->add(Role::ROLE_USER);
        }

        $roles= array();
        foreach ($this->roles as $role){
            $roles[] = (string)$role;
        }

        return array_unique($roles);
    }

    /**
     * @return string The password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return string|null The salt
     */
    public function getSalt() {
        return;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string The username
     */
    public function getUsername() {
        return $this->username;
    }


    public function __toString() {
        return $this->username;
    }
}