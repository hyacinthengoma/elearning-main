<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacheraboutController extends AbstractController
{
    #[Route('/teacherabout', name: 'teacherabout')]
    public function index(): Response
    {
        return $this->render('teacherabout/index.html.twig');
    }
}
