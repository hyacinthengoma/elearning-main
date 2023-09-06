<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\SubCategory;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'app_categories_index', methods: ['GET'])]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoriesRepository $categoriesRepository,SubCategoryRepository $subCategoryRepo): Response
    {
      //  $form = $this->createFormBuilder()
         $form = $this->createFormBuilder(['categories' => $categoriesRepository->find('2')])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($subCategoryRepo) {
                $categories = $event->getData()['categories'] ?? null;


              //  $subcategory =
             //   dd($subCategoryRepo);


            $subcategory = $categories === null ? [] : $subCategoryRepo->findByCategories($categories,['name' => 'ASC']);
                // $subcategory = $categories === null ? [] : $subCategoryRepo->findByCountryOrderedByAscName($categories);
            //$subcategory = $categories === null ? [] : $subCategoryRepo->findByCategories($categories,['name' => 'ASC']);
          //  $subcategory = $categories === null ? [] : $subCategoryRepo->findBy(['categories' => $categories],['name' => 'ASC']);

//
//            createQueryBuilder('c')
//            ->andWhere('c.categories = :categories')
//            ->setParameter('categories', $categories)
//            ->orderBy('c.name', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
        ;
            //dd($subcategory);
                $event->getForm()->add('subcategory', EntityType::class,[
                    'class' => SubCategory::class,
                    'choice_label' => 'name',
                    'choices' => $subcategory,
                    'disabled' => $categories === null,
//                    'query_builder'=> function(SubCategoryRepository $subCategoryRepo) use ($categories){
//                        return $subCategoryRepo->createQueryBuilder('c')
//                            ->andWhere('c.categories = :categories')
//                            ->setParameter('categories', $categories)
//
//                            ->orderBy('c.name','ASC');
//                    },
                    'placeholder'=> 'Selectionner une sous catégorie',
                    'constraints' => new NotBlank(['message' => 'Veuillez sélectionner une sous-catégorie'])

                ]);
            })
            ->add('name',TextType::class,[
                'constraints' => new NotBlank(['message' => 'Veuillez entrer votre nom svp']),
                'help' => 'je suis l\'aide à la saisie que Hyacinthe a créé nommé help dans symfony CategoriesController'
            ])
            //  ->add('courses')
            //  ->add('teachers')
            ->add('categories',EntityType::class,[
                'class'=> Categories::class,
                'placeholder'=> 'Selectionner une catégorie',
               // 'mapped'=> false,
                'query_builder'=> function(CategoriesRepository $categoriesRepo){
                    return $categoriesRepo->createQueryBuilder('c')->orderBy('c.name','ASC');
                },
                 'constraints' => new NotBlank(['message' => 'Veuillez sélectionner une catégorie'])
            ])
          //  ->add('subcategory',EntityType::class,[
          //      'class'=> SubCategory::class,
               // 'disabled' =>true,
           //     'placeholder'=> 'Selectionner une sous catégorie',
             //   'mapped'=> false,
           //     'query_builder'=> function(SubCategoryRepository $subCategoryRepo){
           //         return $subCategoryRepo->createQueryBuilder('c')->orderBy('c.name','ASC');
            //    },
            //     'constraints' => new NotBlank(['message' => 'Veuillez selectionner une sous catégorie'])
          //  ])

           // ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){
                //dd($event->getForm());
               // dd($event->getData());
             // dd($event->setData(['name' => 'd,zkdk']));
               // dd($event);
           // })

            ->getForm();

       // dd($form->getConfig()->getType()->getInnerType());
      //  dd($form->getData());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
//dd($form->getData());
        }

        return $this->renderForm('categories/new.html.twig', [
           // 'category' => $category,
            'form' => $form,
        ]);
    }







/* [Route('/new', name: 'app_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoriesRepository $categoriesRepository): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->save($category, true);

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
*/

    #[Route('/{id}', name: 'app_categories_show', methods: ['GET'])]
    public function show(Categories $category): Response
    {
        return $this->render('categories/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->save($category, true);

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categories_delete', methods: ['POST'])]
    public function delete(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoriesRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
