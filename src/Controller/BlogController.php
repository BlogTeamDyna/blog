<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    //Faire une route pour la création d'un article
    //Faire route pour Modification
    //Faire route pour Suppression
    //Faire route pour lecture(details)
    #[Route('/blog/creation', name: 'blog_creation')]
    public function shox(string $slug): Response
    {
    }
}
