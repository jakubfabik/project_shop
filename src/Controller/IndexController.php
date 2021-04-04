<?php

namespace App\Controller;

use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(EntityManagerInterface $em): Response
    {
      return $this->redirectToRoute('index_show', ['documentId' => 1]);
    }

    /**
     * @Route("/show/{documentId}", name="index_show")
     * @param int $documentId
     */
    public function show(int $documentId, EntityManagerInterface $em){
        $document = $em->find(Document::class, $documentId);
        return $this->render('index/show.html.twig',['document'=> $document]);
    }
}
