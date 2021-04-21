<?php

namespace App\Controller;

use App\Entity\Kategoria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class KosikController extends AbstractController
{

    /**
     * @Route ("/kosik")
     */
    public function kosik(Request $request, SessionInterface $session): Response
    {
        $kosik = $session->get('kosik', []);

        if($request->isMethod('POST')){
            unset($kosik[$request->request->get('id')]);
            $session->set('kosik', $kosik);
        }

        $spolu = array_sum(array_map(function($polozka){
            return $polozka->getCena();
        }, $kosik));

        return $this->render('kosik.html.twig', [
            'kosik' => $kosik,
            'spolu' => $spolu
        ]);
    }
}
