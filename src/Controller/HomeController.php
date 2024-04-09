<?php

namespace App\Controller;


use App\Entity\Tag;
use App\Entity\Article;
use App\Form\HomeType;
use App\Form\PaginationType;
use App\Form\SearchType;
use App\Model\SearchData;
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

        $arrayTagsObject = [];

        foreach ($tags as $tag) {
            $arrayTagsObject[] = $em->getRepository(Tag::class)->find($tag);
        }

        $tagForm = $this->createForm(HomeType::class,null,['selectedTags' => $arrayTagsObject]);

        $numberPerPage = $request->query->get("numPerPage", 3);

        $paginationForm = $this->createForm(PaginationType::class, null,['numberPerPage' => $numberPerPage]);

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

        return $this->render('home.html.twig', [
            'articles' => $articles,
            'form' => $tagForm,
            'forme' => $paginationForm,
            'searchForm' => $searchForm,
            'pagination' => $pagination
        ]);
    }

    public function getTags(EntityManagerInterface $em): Response
    {
        $tags = $em->getRepository(Tag::class)->findAll();

        return $this->render('tag/index.html.twig', [
            'tags' => $tags
        ]);
    }

    public function globalViewsCounter(Article $article): Response
    {
        $globalView = $article->getView();
        dump($globalView);
        return $this->render('home.html.twig',[
            'globalView' => $globalView
        ]);
=======
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route("/", name: "acceuil")]
    public function testAction(): Response
    {
        return $this->render("home.html.twig");
    }
}
