<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistraciaController extends AbstractController
{
    /**
     * @Route("/registracia", name="registracia")
     */
    public function index(): Response
    {
        return $this->render('registracia.html.twig', [
            'controller_name' => 'RegistraciaController',
        ]);
    }
}
