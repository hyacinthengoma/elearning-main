<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\SubCategory;
use App\Repository\CategoriesRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            //  ->add('courses')
            //  ->add('teachers')
            ->add('categories',EntityType::class,[
                'class'=> Categories::class,
                'placeholder'=> 'Sélectionner une catégorie',
                'mapped'=> false,
                'query_builder'=> function(CategoriesRepository $categoriesRepo){
                return $categoriesRepo->createQueryBuilder('c')->orderBy('c.name','ASC');
                }

            ]);





                }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}

