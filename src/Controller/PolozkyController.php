<?php

namespace App\Controller;

use App\Entity\Kategoria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Polozka;

use App\Repository\PolozkaRepository;
use App\Repository\KategoriaRepository;

class PolozkyController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(PolozkaRepository $repository, KategoriaRepository $kategoriaRepository): Response
    {
        $polozky = $repository->findBy([]);
        $kategorie = $kategoriaRepository->findBy([]);
        return $this->render('polozky.html.twig', [
            'polozky' => $polozky,
            'kategorie' => $kategorie,
        ]);
    }

    /**
     * @Route ("/kategorie/{id}")
     */
    public function filter($id, PolozkaRepository $repository): Response
    {
        $polozky = $repository->findFilter($id);

        return $this->render('polozkyFilter.html.twig', [
            'polozky' => $polozky,
        ]);
    }

    /**
     * @Route ("/polozky/{id}")
     */
    public function detail($id, Request $request, PolozkaRepository $repository, SessionInterface $session): Response
    {
        $polozky = $repository->find($id);

        $kosik = $session->get('kosik', []);

        if ($request->isMethod('POST')) {
            $kosik[$polozky->getId()] = $polozky;
            $session->set('kosik', $kosik);
        }

        $vKosiku = array_key_exists($polozky->getId(), $kosik);

        return $this->render('detaily.html.twig', [
            'polozky' => $polozky,
            'vKosiku' => $vKosiku,
        ]);
    }

    /**
     * @Route("/vymaz_polozku/{id}", defaults={"id" = 0}, name="vymaz_polozku")
     * @param Request $request
     * @param int $id
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function vymazPolozku(int $id, EntityManagerInterface $entityManager){
        $polozka = $entityManager->find(Polozka::class, $id);
        $entityManager->remove($polozka);
        $entityManager->flush();
        // presmerovanie na index - zoznam dokumentov
        return $this->forward('App\Controller\PolozkyController::index');

    }
}
