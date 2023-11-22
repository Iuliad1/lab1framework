<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LogController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();
    
    if ($this->getUser()) {
      // Dacă utilizatorul este autentificat,îl redirecționează către ruta 'task/create'
      return $this->redirectToRoute('taskcreate');
  }
    return $this->render('login/index.html.twig', [
    'last_username' => $lastUsername,
    'error' => $error,
         ]);
       }
    }
