<?php

namespace App\Form;

use App\Entity\TeacherMetas;
use App\Entity\Teachers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, [
                'label'=>'Votre email',
                'required'=>true,
                'constraints' => new Length ([
                    'min'=>2,
                    'max'=> 50,
                    'maxMessage' => 'Votre adresse email doit avoir un longueur maximale de 50 caractères',
                ]),
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre email'
                ]
            ])

            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Apprenant' => 'ROLE_APPRENANT',
                    'Mentor' => 'ROLE_MENTOR',

                ],
                'label' => 'Quel est votre profil ?',
                'required' => true,
                'expanded' => true,
                'multiple' => true,

            ])

            ->add('password',RepeatedType::class, [
                'type'=> PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'options' => ['attr' => ['class' => 'password-field']],
                'label'=>'Votre mot de passe',
                'required'=>true,
                'constraints' => new Length ([
                    'min'=> 6,
                    'minMessage' => 'Votre mot de passe doit contenir au moins 6 caractères',
                ]),
                'required'=>true,
                'first_options'=> [
                    'required'=>true,
                    'label' => 'Mot de passe',
                    'attr'=>[
                        'placeholder'=>'Merci de saisir votre mot de passe'
                    ]
                ],
                'second_options'=> [
                    'required'=>true,
                    'label'=> 'Confirmez votre mot de passe',
                    'attr'=>[
                        'placeholder'=>'Merci de confirmer votre mot de passe'
                    ]
                ]
            ])
            ->add('firstname',TextType::class, [
                'label'=>'Prénom',
                'required'=>true,
//                'constraints' => new Length ([
//                    'min'=> 20,
////                    'max'=> 30,
//                    'minMessage' => 'entrez au moins 20 caractères',
//                ]),
//                new Notblank ([
//                    'message'=> 'le champs doit etre rempli'
//
//                ]),
                'attr'=>[
                    'placeholder'=>'Veuillez saisir votre prénom'
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>'Nom',
                'required'=>true,
//                'constraints' => new Length ([
//                    'min'=> 20,
////                    'max'=> 30,
//                    'minMessage' => 'entrez au moins 20 caractères',
//                ]),
//                new Notblank ([
//                    'message'=> 'le champs doit etre rempli'
//
//                ]),
                'attr'=>[
                    'placeholder'=>'Veuillez saisir votre nom'
                ]
            ])

            ->add('illustration',FileType::class,[
                'label' => 'Veuillez téléverser une photo de profil pour vos apprenants (~+10% de conversion)',
                'required' => true,
                'data_class' => null, // To prevent form from validating a non-existent property
                'attr' => [
                    'accept' => 'image/*', // Restrict file types to images
                ],
            ])



            // ->add('slug', TextType::class) //
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => ['class' => 'btn btn-primary'],
            ])



            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();

                if ($data instanceof Teachers ) {
                    $form->add('description', TeacherMetasType::class,[
                        'label' => ' '
                    ]);
                }
            });

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
          //  'data_class' => Teachers::class,
            // Configure your form options here
        ]);
    }
}

