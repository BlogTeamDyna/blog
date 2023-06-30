<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentary;
use App\Form\ArticleType;
use App\Form\CommentaryType;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\RedisPubSubHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    #[Route("/article/new", name: "article_create")]
    public function createAction(Request $request, EntityManagerInterface $em, Article $article = null): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route("/article/details/{id}", name: "article_details")]
    public function detailsAction(Article $article, EntityManagerInterface $em, Request $request): Response
    {
        $user = $this->getUser();
        $commentary = new Commentary();
        $commentary->setArticle($article);
        $commentary->setUser($user);


        $commentaries = $em->getRepository(Commentary::class)->findBy(['article' => $article] , ["created" => "DESC"]);

        $form = $this->createForm(CommentaryType::class, $commentary);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($commentary);
            $em->flush();

            return $this->redirectToRoute('article_details',[
                'id' => $article->getId(),
            ]);
        }

        return $this->render('article/detail.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'commentary' => $commentary,
            'commentaries' => $commentaries
        ]);
    }

    #[Route("/article/edit/{id}", name: "article_edit")]
    public function editAction(EntityManagerInterface $em, Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route("/article/delete/{id}", name: "article_delete")]
    public function deleteAction(EntityManagerInterface $em, Article $article): Response
    {
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }


}
