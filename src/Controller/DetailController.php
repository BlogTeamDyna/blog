<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DetailController extends AbstractController
{
    // Afficher les articles
    #[Route('/details'),]
    public function testAction(): Response
    {

        $date = date("d-m-Y");

        return $this->render("detail.html.twig", [
            'date' => $date,
        ]);

        // $number = random_int(0, 100);

        // return new Response(
        //     '<html><body>Lucky number: ' . $number . '</body></html>'
        // );
    }
}
