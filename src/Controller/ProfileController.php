<?php

namespace App\Controller;

use App\Entity\Learners;
use App\Entity\Teachers;
use App\Form\RegisterLearnersType;
use App\Form\RegisterTeachersType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


use App\Entity\User;
use App\Security\LoginFormAuthAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;


class ProfileController extends AbstractController
{

    protected $slugger;



    #[Route('/profil', name: 'profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }
    private $entityManager;

    public function __construct(EmailVerifier $emailVerifier, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $this->entityManager = $entityManager;
        $this->emailVerifier = $emailVerifier;
        $this->slugger = $slugger;
    }

    #[Route('/inscription-apprenantsssssssss', name: 'register_learners')]
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


    #[Route('/inscription-enseignantsssss', name: 'register_teachers')]
    public function register_teachers(Request $request, UserPasswordHasherInterface $userPasswordHasher,UserAuthenticatorInterface $userAuthenticator, LoginFormAuthAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {

        $notification = null;
        $user = new Teachers();
        $form = $this->createForm(RegisterTeachersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid())
        {
            $notification ='jojdzojo';
            $user = $form->getData();
            $search_email = $this->entityManager->getRepository(Teachers::class)->findOneByEmail($user->getEmail());
            if (!$search_email) {
                $password = $userPasswordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($password)
                    ->setSlug($this->slugger->slug($user->getName()));
                $uploadedFile = $form->get('illustration')->getData();
                if ($uploadedFile) {
                    $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                }
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $uploadedFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setIllustration($newFilename);
                // dd($user);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = "Inscription réussie. Vous pouvez vous connecter à votre espace.";
            } else {
                $notification = "L'email existe déjà.";
            }

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@equiiity.com', 'Equiiity'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->renderForm('teacher-profile/index.html.twig', [
            'form' => $form,
            'notification' => $notification
        ]);
    }

}
