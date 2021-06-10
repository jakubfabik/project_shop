<?php

namespace App\Controller;

use App\Entity\Objednavka;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ObjednavkaRepository;
use Doctrine\ORM\EntityManagerInterface;


class UpravenieObjednavkyController extends AbstractController
{
    /**
     * @Route("/objednavky")
     * @param ObjednavkaRepository $repository
     * @return Response
     */
    public function index(ObjednavkaRepository $repository): Response
    {
        $objednavky = $repository->findAll();

        return $this->render('upravenieObjednavky.html.twig', [
            'objednavky' => $objednavky,
        ]);
    }

    /**
     * @Route("/vymazObjednavku/{objednavkaId}", defaults={"objednavkaId" = 0}, name="vymaz_objednavku")
     * @param int $objednavkaId
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function vymazObjednavku(int $objednavkaId, EntityManagerInterface $entityManager){
        $objednavka = $entityManager->getRepository(Objednavka::class)->findOneBy(['id'=>$objednavkaId]);
        $entityManager->remove($objednavka);
        $entityManager->flush();
        return $this->forward('App\Controller\UpravenieObjednavkyController::index');
    }

    /**
     * @Route("/editObjednavku/{objednavkaId}", defaults={"objednavkaId" = 0}, name="uprav_objednavku")
     * @param int $objednavkaId
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function upravObjednavku(int $objednavkaId, EntityManagerInterface $entityManager) {

        $objednavka = $entityManager->getRepository(Objednavka::class)->findOneBy(['id'=>$objednavkaId]);
        $stavObjednavky = $objednavka->getstav_objednavky();
        $cas = new \DateTime('@'.strtotime('now'));

        if($stavObjednavky == 'nova'){
            $novyStavObjednavky = 'odoslana';
            $objednavka->setStavObjednavky($novyStavObjednavky);
            $objednavka->setCasOdoslania($cas);
        }

        if($stavObjednavky == 'odoslana'){
            $novyStavObjednavky = 'vybavena';
            $objednavka->setStavObjednavky($novyStavObjednavky);
        }

        $entityManager->persist($objednavka);
        $entityManager->flush();

        return $this->forward('App\Controller\UpravenieObjednavkyController::index');
    }
}
