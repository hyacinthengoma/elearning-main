<?php

namespace App\Controller;

use App\Entity\Training;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/training', name: 'training')]
    public function index(): Response
    {
        $trainings = $this->entityManager->getRepository(Training::class)->findAll();
        //dd($trainings);
        return $this->render('training/index.html.twig',[
            'trainings' => $trainings
        ]);
    }
}
