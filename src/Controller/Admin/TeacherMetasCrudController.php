<?php

namespace App\Controller\Admin;

use App\Entity\TeacherMetas;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TeacherMetasCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TeacherMetas::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
          //  IdField::new('id'),
          //  TextField::new('name'),
         //   TextEditorField::new('description'),
//TextareaField::new('name','Nom du professeur'),
            TextareaField::new('description_preview','Description courte du professeur'),
            TextareaField::new('description_complete','Description complète du professeur')
        ];
    }

}
