<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

  


    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
//            TextField::new('title'),
//            TextEditorField::new('description'),
            TextField::new('firstname')
                ->setFormTypeOption('disabled','disabled'),
//                ->setFormTypeOption('disabled','disabled'),
            TextField::new('lastname')
                ->setFormTypeOption('disabled','disabled'),
//            TextField::new('password'),
            ArrayField::new('roles')


        ];

    }

}
