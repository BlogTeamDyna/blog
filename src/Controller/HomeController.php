<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: "homepage")]
    public function homeAction(EntityManagerInterface $em): Response
    {
        $articles = $em->getRepository(Article::class)->findBy([], ["created" => "DESC"]);
        $tags = $em->getRepository(Tag::class)->findAll();



        return $this->render('home.html.twig', [
            'articles' => $articles,
            'tags' => $tags
        ]);
    }
    public function getTags(EntityManagerInterface $em, TagRepository $tagRepository): Response
    {
        $tags = $em->getRepository(Tag::class)->findAll();
        //$tagRepository->findAll(),
        return $this->render('tag/index.html.twig', [
            'tags' => $tags
        ]);
    }
}
