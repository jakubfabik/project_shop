<?php
/*
 * POZOR: Aby toto fungovalo, treba doinstalovat balicek fixtures:
 *  composer require --dev orm-fixtures
 */
namespace App\DataFixtures;

use App\Entity\Document\Category;
use App\Entity\Document\Document;
use App\Entity\User\Role;
use App\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var User
     */
    private $adminUser;

    /**
     * Cez konstruktor mozeme sem mozeme dostat rozne servisy, ktore potom mozeme pouzivat.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Vytvorenie rol a pouzivatelov
     * @param ObjectManager $manager
     */
    public function loadUsers(ObjectManager $manager) {
        // vytvorenie role Administrator
        $roleAdmin = new Role();
        $roleAdmin->setName(Role::ROLE_ADMIN);
        $roleAdmin->setDescription('Administrátor');
        $manager->persist($roleAdmin);

        // vytvorenie role Pouzivatel
        $roleUser = new Role();
        $roleUser->setName(Role::ROLE_USER);
        $roleUser->setDescription('Používateľ');
        $manager->persist($roleUser);

        // Vytvorenie pouzivatela
        $adminUser = new User();
        $adminUser->setFirstName('Janko');
        $adminUser->setSurname('Hraško');
        $adminUser->setUsername('admin');
        $adminUser->setEmail('janko.hrasko@test.umb.sk');
        // hashovanie hesla pomocou predvoleneho encodera aplikacie
        $adminUserPassword = $this->encoder->encodePassword($adminUser, 'Heslo123');

        $adminUser->setPassword($adminUserPassword);
        $adminUser->addRole($roleAdmin);
        $manager->persist($adminUser);
        // odlozim si ho pre pouzitie v inych funkciach
        $this->adminUser = $adminUser;

        $manager->flush();
    }

    /**
     * Vytvorenie kategorii a dokumentov
     * @param ObjectManager $manager
     */
    public function loadDocuments(ObjectManager $manager) {
        $mainMenuCategory = new Category();
        $mainMenuCategory->setCode(Category::CODE_MAIN_MENU);
        $mainMenuCategory->setName('Hlavné menu');
        $manager->persist($mainMenuCategory);

        $document = new Document();
        $document->setName('Úvod');
        $document->setCode(Document::CODE_INDEX_DOCUMENT);
        $document->setContent('<h1>Vitajte,</h1><p>na našej stránke.</p>');
        $document->setPublished(true);
        $document->setAuthor($this->adminUser);
        $document->setCategory($mainMenuCategory);
        $manager->persist($document);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadDocuments($manager);
    }
}
