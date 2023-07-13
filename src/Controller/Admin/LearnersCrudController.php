<?php

namespace App\Controller\Admin;

use App\Entity\Learners;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LearnersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Learners::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add('index', 'detail');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email','Adresse Email'),
//            TextField::new('title'),
//            TextEditorField::new('description'),
            TextField::new('firstname','Prénom'),
//                ->setFormTypeOption('disabled','disabled'),
//                ->setFormTypeOption('disabled','disabled'),
            TextField::new('lastname','Nom'),
//                ->setFormTypeOption('disabled','disabled'),
             TextField::new('password','Mot de passe')
                ->setFormType(PasswordType::class)
                 ->onlyOnForms()
               //  ->hideOnIndex(),
            //ArrayField::new('roles')


        ];
    }

}
