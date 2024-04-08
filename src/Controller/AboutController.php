<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AboutController extends AbstractController
{

    #[Route('/about', name: 'about', methods: ['GET'])]
    public function index(): Response {

        return $this->render('about/about.html.twig');

    }
}