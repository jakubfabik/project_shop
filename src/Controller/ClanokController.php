<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClanokRepository;

use App\Entity\Clanok;
use App\Entity\User\User;
use App\Form\User\EditUserType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Comment\Doc;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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

    /**
     * @Route("/novy_clanok")
     */
    public function novy_clanok(ClanokRepository $repository): Response
    {
        return $this->render('novy_clanok.html.twig',[]);
    }

    /**
     * @Route("/edit/{clanokId}", defaults={"clanokId" = 0}, name="uprav_clanok")
     * @param Request $request
     * @param int $clanokId
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function upravClanok(Request $request, int $clanokId, LoggerInterface $logger, EntityManagerInterface $entityManager) {

        if ($clanokId == 0) {
            $logger->info("Vytvorit novy článok");
            $documentModel = new Clanok();
            /** @var User $user */
            $user = $this->getUser();
        } else {
            $logger->info("Upravit článokt: {$clanokId}");
            $documentModel = $entityManager->find(Clanok::class, $clanokId);
        }

        $form = $this->createForm(UpravClanokController::class, $documentModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($documentModel);
                $entityManager->flush();
                if ($clanokId == 0) {
                    $this->addFlash('success', "Článok {$documentModel->getNazov()} bol vytvorený.");
                } else {
                    $this->addFlash('success', "Článok {$documentModel->getNazov()} bol upravený.");
                }

            } catch (\Exception $e) {
                $this->addFlash('danger', "Článok sa nepodarilo uložiť: {$e->getMessage()}");
            }

            return $this->forward('App\Controller\ClanokController::index');
        }

        return $this->render('edit.html.twig', array(
            'form'           => $form->createView()
        ));
    }


}
