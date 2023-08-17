<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EnregistrementType;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $notification = null;
        $user = new User();
        $form = $this->createForm(RegisterType::class);
//        $variable = $_ENV['TWILIO_API_KEY_SID'];
//        dd($variable);

        //$role = new User();
        //$roles = $role->getRoles();
        //dd($roles);

        //soumission formulaire

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid())
        {
            $notification ='jojdzojo';
            $user_data = $form->getData();
//            dd($user_data);
            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user_data['email']);
            if (!$search_email)
            {
                $user->setEmail($user_data['email']);
                $user->setRoles($user_data['roles']);
                //ne pas remettre la ligne uste en dessous
               $password = $hasher->hashPassword($user, $user_data['password']);
                $user->setPassword($password);
              //  $user->setFirstname($user_data['firstname']);
              //  $user->setLastname($user_data['lastname']);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification ="Inscription réussie. Vous pouvez vous connecter à votre espace";
            }else{
                $notification = "L'email existe déjà";
            }
        }
        return $this->renderForm('register/index.html.twig', [
            'form' => $form,
            'notification' => $notification
        ]);
    }
}
