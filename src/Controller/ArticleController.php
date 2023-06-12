<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Config\Doctrine;




//Faire une route pour la création d'un article
//Faire route pour Modification
//Faire route pour Suppression
//Faire route pour lecture(details)


class ArticleController extends AbstractController
{

    #[Route("/article/create",)]

    public function createAction(Request $request): Response
    {
        $article = new Article();
        // $article->setTitle('Ecrire nouveaublog');
        // $article->setDescription('Nouvel article');


        $form = $this->createForm(ArticleType::class, $article, [
            'action' => $this->generateUrl('form_success'),
            'method' => 'GET',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setTitle($request);
            $article->setDescription($request);

            // $doctrine = $this->getDoctrine()->getManager();


            // $doctrine->persist($article);


            // $doctrine->flush();


            $article = $form->getData();

            return $this->redirectToRoute('form_success');
        }

        return $this->render('new.html.twig', [
            'form' => $form,
        ]);
    }

    // public function deleteAction() 
}
