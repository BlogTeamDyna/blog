<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/')]
    public function homeAction(): Response
    {
        //Recuperer tout les articles de la bdd
        //Envoyer en paramètre les articles au twig
        return $this->render('home.html.twig',);
    }
}
