<?php

namespace App\Controller;

use App\Entity\Document;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $document1 = new Document();
        $document1->setName('Uvodna stranka');
        $document1->setContent('Toto je uvodna stranka.');
        $manager->persist($document1);

        $document2 = new Document();
        $document2->setName('Podstranka');
        $document2->setContent('Toto je podstranka.');
        $manager->persist($document2);

        $manager->flush();
    }
}
