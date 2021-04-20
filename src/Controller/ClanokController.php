<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClanokRepository;

class ClanokController extends AbstractController
{
    /**
     * @Route("/clanok", name="clanok")
     */
    public function index(ClanokRepository $repository): Response
    {
        $clanky = $repository->findBy([]);
        return $this->render('clanok.html.twig', [
            "clanky" => $clanky,
        ]);
    }
}
