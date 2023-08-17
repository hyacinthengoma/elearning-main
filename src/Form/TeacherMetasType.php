<?php

namespace App\Form;

use App\Entity\TeacherMetas;
use Doctrine\DBAL\Types\TextType;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherMetasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description_preview',null,[
                'label' =>'Description brève'
            ])
            ->add('description_complete',null, [
                'label' => 'Description longue'
            ])
     //       ->add('teachers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeacherMetas::class,
        ]);
    }
}
