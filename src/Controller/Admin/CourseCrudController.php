<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Entity\CourseMetas;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Course::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
            AssociationField::new('teacher','Bienvenue'),
            AssociationField::new('categories', 'Matière'),
            TextField::new('name','Nom du cours'),
            SlugField::new('slug')
                ->setTargetFieldName('name'),
            AssociationField::new('level_name','Niveau'),
           // ->renderAsNativeWidget(),
//            TextField::new('title'),
//            TextEditorField::new('description_preview'),
//            TextEditorField::new('description_complete'),
            MoneyField::new('course_price','Prix',)
                ->setCurrency('EUR'),
          //  NumberField::new('difficulty','Niveau'),
            DateTimeField::new('created_at','Créé le'),
            DateTimeField::new('updated_at', 'Mis à jour le'),
            //AssociationField::new('course_meta_id'),
            //AssociationField::new('description', 'Description'),
            AssociationField::new('description', 'Description')
                ->renderAsEmbeddedForm(),

               /// ->autocomplete(),
           // AssociationField::new('description_complete','Description complète')
        //->renderAsNativeWidget(),
               // ->setFormTypeOption('csrf_protection', true),
              //  ->setFormTypeOption('mapped', false),

            //TextField::new('course_meta_id')






           // AssociationField::new('description_complete')
           //     ->autocomplete()
           //     ->renderAsNativeWidget()
           //     ->setFormTypeOption('by_reference', true),

         //   AssociationField::new('course_meta_id')
         //       ->autocomplete(),

        ];
    }

}
