<?php
/**
 * Created by PhpStorm.
 * User: Jakub Fábik
 * Date: 4/11/2021
 * Time: 4:11 PM
 */
 namespace App\Controller;

 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 class WelcomeController extends AbstractController
 {
     /**
      * @Route("/welcome")
      */
     public function homepage(): Response
     {
         return $this->render('welcome.html.twig');
     }
 }