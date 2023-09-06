<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\SubCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
          //  IdField::new('id'),
            TextField::new('name','Catégorie'),
            AssociationField::new('subcategory','Sous catégorie')
                ->setFormType(SubCategory::class,[
                    'class' => SubCategory::class,
                    'choice_label' => 'name',
                ])
        ];
    }

}
