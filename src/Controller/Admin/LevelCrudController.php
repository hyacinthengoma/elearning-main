<?php

namespace App\Controller\Admin;

use App\Entity\Level;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LevelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Level::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Niveau'),
          //  IdField::new('id'),
          //  TextField::new('title'),
          //  TextEditorField::new('description'),
        ];
    }

}
