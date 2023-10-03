<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $message = "Bonjour mes étudiants";
        
        return new Response ("<h1>$message</h1>");
    }
    
    #[Route('/go-to-index', name: 'go_to_index')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('app_home');
    }

}
