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

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $this->entityManager = $entityManager;
        $this->emailVerifier = $emailVerifier;
        $this->slugger = $slugger;
    }

    #[Route('/inscription-enseignants', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $notification = null;
        $user = new Teachers();
        $form = $this->createForm(RegisterTeachersType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid())
        {
            $notification ='jojdzojo';
            $user = $form->getData();
            //dd($user);
            $search_email = $this->entityManager->getRepository(Teachers::class)->findOneByEmail($user->getEmail());
            if (!$search_email) {
                $password = $userPasswordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($password)
                    ->setSlug($this->slugger->slug($user->getName()))
                    ->setRoles(['ROLE_MENTOR']);
               // dd($user);
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



    #[Route('/inscription-apprenants', name: 'register_learners')]
    public function registerlearners(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthAuthenticator $authenticator, EntityManagerInterface $entityManager,EmailVerifier $emailVerifier): Response
    {
        $notification = null;
        $user = new Learners();
        $form = $this->createForm(RegisterLearnersType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $notification ='jojdzojo';
            $user = $form->getData();
            //dd($user);
            $search_email = $this->entityManager->getRepository(Learners::class)->findOneByEmail($user->getEmail());
            if (!$search_email) {
                $password = $userPasswordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($password)
                  //  ->setSlug($this->slugger->slug($user->getName()))
                    ->setRoles(['ROLE_USER']);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = "Inscription réussie. Vous pouvez vous connecter à votre espace.";
            } else {
                $notification = "L'email existe déjà.";
            }
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
        return $this->render('learners/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }










    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
