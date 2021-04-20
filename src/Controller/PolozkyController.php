<?php

namespace App\Controller;

use App\Entity\Kategoria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function detail($id, PolozkaRepository $repository): Response
    {
        $polozky = $repository->find($id);

        return $this->render('detaily.html.twig', [
            'polozky' => $polozky,
        ]);
    }
}
