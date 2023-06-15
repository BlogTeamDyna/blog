<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class HomeController extends AbstractController
{
    #[Route('/', name: "homepage")]
    public function homeAction(EntityManagerInterface $em): Response
    {
        $articles = $em->getRepository(Article::class)->findAll();

        return $this->render('home.html.twig', [
            'articles' => $articles,
        ]);
        // OK Recuperer tout les articles de la bdd
        // OK Envoyer en paramètre les articles au twig

    }
}
