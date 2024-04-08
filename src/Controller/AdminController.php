<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentary;
use App\Entity\User;
use App\Form\SearchType;
use App\Model\SearchData;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController {

    #[Route("/admin", name: "adminpage")]
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator): Response
    {

        $user = $this->getUser();
        $page = $request->query->get('page', 1);

        $articles = $em->getRepository(Article::class)->getAll();
        $commentary = $em->getRepository(Commentary::class)->findAll();

        $numberPerPage = $request->query->get("numPerPage", 3);

        $searchData = new SearchData();
        $searchData->setSearch($request->query->get("recherche", ""));

        $searchForm = $this->createForm(SearchType::class, $searchData);

        if($searchData->getSearch() != "") {
            $articles = $em->getRepository(Article::class)->searchByTitleAndDescription(
                $searchData->getSearch()
            );
        }

        $pagination = $paginator->paginate(
            $articles,$page,$numberPerPage
        );


        return $this->render('admin/admin.html.twig', [
            'articles' => $articles,
            'commentary' => $commentary,
            'user'   => $user,
            'id' => $user->getId(),
            'pagination' => $pagination,
            'searchForm' => $searchForm,

        ]);
    }
}