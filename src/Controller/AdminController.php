<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentary;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController {

    #[Route("/admin", name: "adminpage")]
    public function index(EntityManagerInterface $em): Response
    {

        $user = $this->getUser();

        $articles = $em->getRepository(Article::class)->findAll();
        $commentary = $em->getRepository(Commentary::class)->findAll();

        return $this->render('admin/admin.html.twig', [
            'articles' => $articles,
            'commentary' => $commentary,
            'user'   => $user,
            'id' => $user->getId(),
        ]);
    }
}