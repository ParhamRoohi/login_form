<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login_page')]
    public function login(Request $request, EntityManagerInterface $entityManager): Response
    {
        $error = null;
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $password = $request->request->get('password');
            if (!(empty($name) || empty($password))) {
                $userRepository = $entityManager->getRepository(User::class);
                $user = $userRepository->findOneBy(['name' => $name]);
                if ($user && $password === $user->getPassword()) {
                    $loginCount = $user->getLoginCount();
                    $user->setLoginCount($loginCount + 1);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $this->redirectToRoute('welcome_page', ['name' => $name]);
                } else {
                    $error = "Name or password is incorrect.";
                }
            } else {
                $error = "Name and Password are required.";
            }
        }
        return $this->render('login_controller/index.html.twig', [
            'controller_name' => 'LoginController',
            'error' => $error
        ]);
    }
}
