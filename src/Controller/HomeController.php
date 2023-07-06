<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Article;
use App\Form\HomeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: "homepage")]
    public function homeAction(EntityManagerInterface $em, Request $request): Response
    {
        $articles = $em->getRepository(Article::class)->findBy([], ['title' => 'DESC']);
//        $tags = $em->getRepository(Tag::class)->findAll();
        $form = $this->createForm(HomeType::class, null);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();

            $articles = $em->getRepository(Article::class)->getByTags($tag);


//            $tags = $em->getRepository(Tag::class)->findBy(['articles' => $articles]);

        }

        // creation d'un nouveau formulaire de filtre tags
        // a la selection d'un tag (form is submited ...) je filter les article par tags
        // la variable articles (deja existante contiendra les uniquement les articles qui auront le tags en question)

        return $this->render('home.html.twig', [
            'articles' => $articles,
//            'tags' => $tags,
            'form' => $form,
        ]);
    }
    public function getTags(EntityManagerInterface $em): Response
    {
        $tags = $em->getRepository(Tag::class)->findAll();

        return $this->render('tag/index.html.twig', [
            'tags' => $tags
        ]);
    }



}
