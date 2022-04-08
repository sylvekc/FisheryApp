<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutFisheryController extends AbstractController
{
    #[Route('/about/fishery', name: 'app_about_fishery')]
    public function index(): Response
    {
        return $this->render('about_fishery/index.html.twig', [
            'controller_name' => 'AboutFisheryController',
        ]);
    }
}
