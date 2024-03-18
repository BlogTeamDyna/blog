<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentary;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\SearchType;
use App\Form\CommentaryType;
use App\Repository\ArticleRepository;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController
{
    #[Route("/article/new", name: "article_create")]
    public function createAction(Request $request, EntityManagerInterface $em, SluggerInterface $slugger,FileUploaderService $fileUploaderService,Article $article = null): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $user = $this->getUser();

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        $article->setUser($user);
        $user->addArticle($article);

        if ($form->isSubmitted() && $form->isValid()) {

            $articleFile = $form->get('image')->getData();

            if ($articleFile) {
                $fileName = $fileUploaderService->upload($articleFile);
                $article->setImage($fileName);
            }
            $em->persist($article);
            $em->flush();

            $this->addFlash(
                'notice',
                'Article créé avec succes'
            );
            return $this->redirectToRoute('homepage');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route("/article/details/{id}", name: "article_details")]
    public function detailsAction(Article $article, EntityManagerInterface $em, Request $request): Response
    {
        $article->increment();
        $em->persist($article);
        $em->flush();

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

            $this->addFlash(
                'notice',
                'Un commentaire a été déposé !'
            );

            return $this->redirectToRoute('article_details',[
                'id' => $article->getId(),
            ]);
        }

        return $this->render('article/detail.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'commentary' => $commentary,
            'commentaries' => $commentaries,
        ]);
    }

    #[Route("/article/edit/{id}", name: "article_edit")]
    public function editAction(EntityManagerInterface $em, Request $request, Article $article,FileUploaderService $fileUploaderService): Response
    {
        $this->denyAccessUnlessGranted('edit', $article);

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $articleFile = $form->get('image')->getData();
            if ($articleFile) {
                $fileName = $fileUploaderService->upload($articleFile);
                $article->setImage($fileName);
            }

            $em->persist($article);
            $em->flush();
            $this->addFlash(
                'notice',
                'Article modifié avec success'
            );
            return $this->redirectToRoute('homepage');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route("/article/delete/{id}", name: "article_delete")]
    public function deleteAction(EntityManagerInterface $em, Article $article): Response
    {
        $this->denyAccessUnlessGranted('delete', $article);
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('homepage');
    }

}
