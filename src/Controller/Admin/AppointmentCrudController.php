<?php

namespace App\Controller\Admin;

use App\Entity\Appointment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\DateTime;

class AppointmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Appointment::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
           // IdField::new('id'),
            TextField::new('title', 'Titre du rendez-vous'),
            DateTimeField::new('start'),
            DateTimeField::new('end'),
            AssociationField::new('teachers'),
            MoneyField::new('price')->setCurrency('XOF'),



        ];
    }

}
