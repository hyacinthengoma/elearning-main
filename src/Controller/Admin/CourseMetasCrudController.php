<?php

namespace App\Controller\Admin;

use App\Entity\CourseMetas;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CourseMetasCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CourseMetas::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
//                ->setFormTypeOption('disabled','disabled'),
           // TextField::new('courses'),
           // AssociationField::new('courses')

       //     ->setProperty('courses'),
    ///                ->setFormTypeOption('disabled','disabled'),
            //TextField::new('name'),
            //TextEditorField::new('meta_key', 'Description brève'),
            //TextEditorField::new('meta_val', 'Description complète'),
            TextareaField::new('meta_key','Description courte'),
            TextareaField::new('meta_val','Description complète')
          //  TextareaField::new('meta_val', \ENT_COMPAT | \ENT_HTML5)->setLabel('Description complète')

        ];
    }

}
