<?php

namespace App\Controller\Admin;

use App\Entity\Teachers;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class TeachersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Teachers::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            //TextField::new('name', 'Nom complet du professeur'),

            TextField::new('firstname', 'Votre prénom'),
            TextField::new('lastname', 'Votre nom'),

            SlugField::new('slug')
            ->setTargetFieldName(['lastname' , 'firstname']),


            EmailField::new('email', 'Adresse Email'),
            AssociationField::new('description')->renderAsEmbeddedForm(),
           //     ->setTargetFieldName(['lastname','firstname']),
//            TextField::new('title'),
//            TextEditorField::new('description'),
           // TextField::new('firstname', 'Prénom'),

//                ->setFormTypeOption('disabled','disabled'),
           // TextField::new('lastname', 'Nom'),
           // SlugField::new('slug')
           //     ->setTargetFieldName(['lastname','firstname']),

            ImageField::new('illustration')
                ->setBasePath('/uploads')
                ->setUploadDir('public/uploads')
                //pour setUploadDir : il faut preciser public
                ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired('false'),

            TextField::new('password', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->onlyOnForms()
                ->hideOnIndex()

//            ArrayField::new('roles')


        ];
    }

}
