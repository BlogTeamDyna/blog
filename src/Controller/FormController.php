<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


//Faire une route pour la création d'un article
//Faire route pour Modification
//Faire route pour Suppression
//Faire route pour lecture(details)


class FormController extends AbstractController
{

    #[Route("/article/create",)]

    public function createAction(Request $request): Response
    {
        $article = new Article();
        $article->setTitle('Ecrire nouveaublog');
        $article->setDescription('Nouvel article');


        $form = $this->createForm(ArticleType::class, $article);

        return $this->render('new.html.twig', [
            'form' => $form,
        ]);
    }

    // public function deleteAction() 
}
