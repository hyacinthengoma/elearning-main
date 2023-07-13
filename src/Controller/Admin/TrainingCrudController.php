<?php

namespace App\Controller\Admin;

use App\Entity\Training;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;

class TrainingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Training::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Titre de la formation'),
            SlugField::new('slug','Titre de la formation pour la fonction de recherche sur le site')
               ->setTargetFieldName('name'),
           AssociationField::new('teacher','Professeur'),
          //  ->setDisabled(),

            TextareaField::new('video_name','Nom de la vidéo'),
            TextareaField::new('video_url','URL de la vidéo'),
            AssociationField::new('description', 'Description')
                ->renderAsEmbeddedForm(),
            ImageField::new('illustration')
                ->setBasePath('/uploads')
                ->setUploadDir('public/uploads')
                //pour setUploadDir : il faut preciser public
                ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired('false'),

            MoneyField::new('price','Prix')
                ->setCurrency('EUR'),
            BooleanField::new('subscribed','Souscrit'),
           // ->setDisabled(),
            IntegerField::new('difficulty','Difficulté'),
            DateTimeField::new('created_at','Créé le '),
            DateTimeField::new('updated_at','Mis à jour le'),


        ];
    }

}
