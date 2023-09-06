<?php

namespace App\Controller\Admin;

use App\Entity\SubCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SubCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubCategory::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
          //  IdField::new('id'),
            AssociationField::new('categories','Catégorie'),
            TextField::new('name','Sous catégorie'),
        ];
    }

}
