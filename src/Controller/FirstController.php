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

 class FirstController
 {
     /**
      * @Route("/first")
      */
     public function homepage(): Response
     {
         return new Response('<html><body><h1>Zaciatok</h1></body>');
     }
 }