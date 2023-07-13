<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AdminCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Admin::class;
    }


    public function configureFields(string $pageName): iterable
    {
         return [
            EmailField::new('email'),
//            TextField::new('title'),
//            TextEditorField::new('description'),
//            TextField::new('firstname')
//                ->setFormTypeOption('disabled','disabled'),
////                ->setFormTypeOption('disabled','disabled'),
//            TextField::new('lastname')
//                ->setFormTypeOption('disabled','disabled'),
            TextField::new('password'),
            ArrayField::new('roles')


        ];
    }

}
