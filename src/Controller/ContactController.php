<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{

    #[Route('/contact', name: 'contact', methods: ['GET'])]
    public function index(): Response {

        return $this->render('contact/contact.html.twig');

    }
}