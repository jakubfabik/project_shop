<?php

namespace App\Controller;

use App\Repository\ObjednavkaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Kategoria;
use App\Entity\Objednavka;
use App\Repository\PolozkaRepository;
use App\Entity\User\User;


class DokoncenieObjednavkyController extends AbstractController
{

    /**
     * @Route ("/dokoncenieObjednavky")
     */
    public function dokoncenieObjednavky(Request $request, ObjednavkaRepository $repo, SessionInterface $session): Response
    {
        $polozkyVobjednavke = "";
        $userID = 0;
        $kosik = $session->get('kosik', []);
        $spolu = array_sum(array_map(function($polozka){
            return $polozka->getCena();
        }, $kosik));

        foreach ($kosik as $it){
            $polozkyVobjednavke .= " ";
            $polozkyVobjednavke .= $it->getID();
        }

        $objednavka = new Objednavka;
        $cas = new \DateTime('@'.strtotime('now'));
        $objednavka->setCasVytvorenia($cas);
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class);
        $users = $user->findAll();
        foreach ($users as $us){
            if($us->getUsername() == $this->getUser()){
                $userID = $us->getID();
            }
        }

        $form = $this->createFormBuilder($objednavka)
            ->add('potvrdenie_objednavky',SubmitType::class, ['label' => 'Potvrdenie objednavky'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //todo zapisat do databazy objednavku
            $objednavka->setStavObjednavky("nova");
            $objednavka->setCasVytvorenia($cas);
            $objednavka->setCasOdoslania($cas);
            $objednavka->setuser($userID);
            $objednavka->setZoznamPoloziek($polozkyVobjednavke);


            $entityManager->persist($objednavka);
            $entityManager->flush();

            $session->set('kosik', []);


            return $this->render('potvrdenieObjednavky.html.twig');
        }



        return $this->render('dokoncenieObjednavky.html.twig', [
            'spolu' => $spolu,
            'form' => $form->createView(),
            'pouzivatel' => $this->getUser(),
            'cas_vytvorenia' => $cas,
            'stav' => 'nová',
            'userID' => $userID,
            'polozkyID' => $polozkyVobjednavke

        ]);


    }

}
