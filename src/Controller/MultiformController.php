<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MultiformController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/multiform/step1', name: 'app_multiform')]
    public function step1(): Response
    {
        $skills = $this->entityManager->getRepository(Skill::class)->findAll();
     //   $skills = $this->entityManager->getRepository(Skill::class)->findAll();
       // dd($skills);


        return $this->render('multiform/step1.html.twig', [
            'skills' => $skills,
        ]);
    }

    #[Route('/multiform/step2', name: 'app_multiform_step2')]
    public function step2(): Response
    {
        return $this->render('multiform/step2.html.twig', [
            'controller_name' => 'MultiformController',
        ]);
    }
    #[Route('/multiform/step3', name: 'app_multiform_step3')]
    public function step3(): Response
    {
        return $this->render('multiform/step3.html.twig', [
            'controller_name' => 'MultiformController',
        ]);
    }
}

