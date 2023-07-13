<?php

namespace App\Controller;

use App\Entity\Learners;
use App\Form\RegisterLearnersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LearnersController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription-apprenants', name: 'register_learners')]
    public function register(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $notification = null;
        $user = new Learners();
        $form = $this->createForm(RegisterLearnersType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user_data = $form->getData();
            $search_email = $this->entityManager->getRepository(Learners::class)->findOneByEmail($user_data->getEmail());
            if (!$search_email) {
                $password = $hasher->hashPassword($user, $user_data->getPassword());
                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = "Inscription réussie. Vous pouvez vous connecter à votre espace.";
            } else {
                $notification = "L'email existe déjà.";
            }
        }
        return $this->render('learners/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
