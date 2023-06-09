<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DetailController extends AbstractController
{
    #[Route('/details')]
    public function testAction(): Response
    {
        return $this->render("detail.html.twig");

        // $number = random_int(0, 100);

        // return new Response(
        //     '<html><body>Lucky number: ' . $number . '</body></html>'
        // );
    }

    public function date()
    {
        return "Today is " . date("Y-m-d") . "<br>";
    }
}
