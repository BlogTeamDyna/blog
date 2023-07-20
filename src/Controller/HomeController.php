<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Article;
use App\Form\HomeType;
use App\Form\PaginationType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: "homepage")]
    public function homeAction(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator
    ): Response
    {
        $articles = $em->getRepository(Article::class)->getAll();
        $page = $request->query->get('page', 1);

        $form = $this->createForm(HomeType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {

            $page = 1;

            $tags = $form->getData();

            if(!$tags['tags']->isEmpty()) {
                $articles = $em->getRepository(Article::class)->getByTags($tags['tags']);
            }
        }

        $pagination = $paginator->paginate(
            $articles,$page,3
        );

        $forme = $this->createForm(PaginationType::class);
        dump($forme);

        return $this->render('home.html.twig', [
            'articles' => $articles,
            'form' => $form,
            'forme' => $forme,
            'pagination' => $pagination
        ]);
    }

    public function getPersonalizedPagination(Request $request, ): Response
    {
        $forme = $this->createForm(PaginationType::class);

        return $this->render('home.html.twig', [
            'forme' => $forme,
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
