<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CourseController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/course', name: 'course')]
    public function index(): Response
    {

        $courses = $this->entityManager->getRepository(Course::class)->FindOneBy(['id' => 1]);

        $course_meta = $this->entityManager->getRepository(Course::class)->findByCourseMetaJoin(1);
//            dd($courses);
//            dd$($course_meta);
        return $this->render('course/index.html.twig',[
            'course_meta' => $courses
        ]);
    }
}
//recupeerer le course id 1 avec tous sont contenu de la table

//jointure : recuperer tuotes les courses meta qui ont course id =1
/** SELECT * FROM COURSE AS C INNER JOIN COURSE_META AS CM WHERE CM.COURSE_ID = 1  */