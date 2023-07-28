<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Article;
use App\Form\HomeType;
use App\Form\PaginationType;
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

        $tags = $request->query->get('selectedTags');


        if( $tags !== null && $tags !== "" ) {

            $tags = explode(',', $tags);
            $articles = $em->getRepository(Article::class)->getByTags($tags);

        } else {
            $tags = [];
        }

        // envoyer url courante avec tout les parametres
        // Pour chaque tag receptionné, recupérer son objet et hydrater arrayTagsObject

        $arrayTagsObject = [];

        foreach ($tags as $tag) {
            $arrayTagsObject[] = $em->getRepository(Tag::class)->find($tag);
        };

        $form = $this->createForm(HomeType::class,null,['selectedTags' => $arrayTagsObject]);


        $numberPerPage = $request->query->get("numPerPage", 3);

        $forme = $this->createForm(PaginationType::class, null,['numberPerPage' => $numberPerPage]);


        $pagination = $paginator->paginate(
            $articles,$page,$numberPerPage
        );


        if ($forme->isSubmitted() && $forme->isValid()) {

            $perPage = $numberPerPage;

            $forme->getData();

            if ($forme['tri'] === '6') {
                $perPage = 6;
            } else if ($forme['tri'] === '9') {
                $perPage = 9;
            }

        }


        return $this->render('home.html.twig', [
            'articles' => $articles,
            'form' => $form,
            'forme' => $forme,
            'pagination' => $pagination
        ]);
    }

//    public function getPersonalizedPagination(Request $request, ): Response
//    {
//        $forme = $this->createForm(PaginationType::class);
//
//        return $this->render('home.html.twig', [
//            'forme' => $forme,
//        ]);
//    }
    public function getTags(EntityManagerInterface $em): Response
    {
        $tags = $em->getRepository(Tag::class)->findAll();

        return $this->render('tag/index.html.twig', [
            'tags' => $tags
        ]);
    }
}
