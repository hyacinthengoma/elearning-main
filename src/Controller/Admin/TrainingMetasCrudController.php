<?php

namespace App\Controller\Admin;

use App\Entity\TrainingMetas;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class TrainingMetasCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TrainingMetas::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
          //  IdField::new('id'),
          //  TextField::new('title'),
           // TextEditorField::new('description'),


            TextareaField::new('description_preview','Description courte de la vidéo'),
            TextareaField::new('description_complete','Description complète de la vidéo')
        ];
    }

}
