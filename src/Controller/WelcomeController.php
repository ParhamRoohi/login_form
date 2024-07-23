<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class WelcomeController extends AbstractController
{
    #[Route('/welcome/{name}', name: 'welcome_page')]

    public function welcome(string $name): Response
    {
        return $this->render('welcome_controller/index.html.twig', [
            'name' => $name,
        ]);
    }
}
