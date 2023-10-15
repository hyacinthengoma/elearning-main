<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Categories;
use App\Entity\Course;
use App\Entity\SubCategory;
use App\Entity\TeacherMetas;
use App\Entity\Teachers;
use App\Repository\AppointmentRepository;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/teacher', name: 'teacher')]
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig');
    }

    #[Route('/profil-enseignant', name: 'teacher')]
    public function profil_enseignant(): Response
    {
        $teachers = $this->entityManager->getRepository(Teachers::class)->findAll();
      //  dd($teachers);
     //   $description = $this->entityManager->getRepository(TeacherMetas::class)->findAll();
    //dump($teachers);
        return $this->render('teacher/index.html.twig',[
            'teachers' => $teachers
        ]);
    }

    #[Route('/teacher/{slug}', name: 'teacher_info')]
    public function show($slug, AppointmentRepository $appointment,Teachers $teacherResa): Response
    {
        $teachers = $this->entityManager->getRepository(Teachers::class)->findOneBySlug($slug);
        $events = $this->entityManager->getRepository(Appointment::class)->findOneBy(['teachers' => $teacherResa]);
		//dd($events);
        if ($events !== null) {
            $events = $this->entityManager->getRepository(Appointment::class)->findOneBy(['teachers' => $teacherResa]);
        } else {

            $teacher = $this->entityManager->getRepository(Teachers::class)->findOneById($teacherResa);
            return $this->render('teacher/show.html.twig', [
                'teachers' => $teachers
            ]);
        }
        // dd($teacher);
        //dd($events);
        $appointmentsbyteachers = $events->getTeachers();
        // dd($appointmentsbyteachers);
        $appointmentsbyteachersrefs = $appointmentsbyteachers->getId();
        //  dd($appointmentsbyteachersrefs);

        return $this->render('teacher/show.html.twig',[
            'teacher_id'=>$appointmentsbyteachersrefs,
            'teachers' => $teachers
        ]);
    }


    public function hour($start, $end){

        $interval = new \DateInterval('PT1H'); // Interval of 1 hour
        $period = new \DatePeriod($start, $interval, $end);
        foreach ($period as $date)
        {
            // $date_and_time = $date->format('d-m-Y H:i:s');
            //  $dates_only = $date->format('d-m-Y');
            // $times = $date->format('H:i:s');
            // $hours[] = [$dates_only, $times];

            //  $hours[] = [$date->format('d-m-Y'), $date->format('H:i:s')];
            // $date_and_time = $date->format('d-m-Y H:i:s');
            $date_and_time = $date->format('H:i:s');

            $date_only = $date->format('d-m-Y');
            $hours[$date_only][] = $date_and_time;
        }

			$formatted_hours = [];
			foreach ($hours as $date => $time_array)
            {
			$formatted_hours[$date] = implode(', ', $time_array);
			}
            return $formatted_hours;
    }
    /**
     * @Route("/appointments/hours/{id}", name="appointments_hours")
     */
    public function getAppointmentHours(int $id)
    {
        $appointments = $this->entityManager->getRepository(Appointment::class)->findBy(['teachers'=>$id]);
        $hours = [];
        $intervalId = 0;

        foreach ($appointments as $appointment) {
            if ($appointment->getCourseId() == null) {
                $start = $appointment->getStart();
                $end = $appointment->getEnd();

                $interval = new DateInterval('PT1H'); // Create an interval of 1 hour

                $currentHour = clone $start;
                while ($currentHour < $end) {
                    $nextHour = clone $currentHour;
                    $nextHour->add($interval); // Add 1 hour to the current hour

                    if ($nextHour > $end) {
                        $nextHour = clone $end;
                    }

                    $hours[] = [
                        'id' => $appointment->getId() . '' . $intervalId++,
                        'start' => $currentHour->format('Y-m-d H:i:s'),
                        'end' => $nextHour->format('Y-m-d H:i:s'),
                        'title' => $appointment->getTitle(),
                        'price' => $appointment->getPrice(),
                    ];
//dd($hours);
                    $currentHour = clone $nextHour;
                }
            }
        }


//dd($hours);
        return new JsonResponse($hours);

    }


    /**
     * @Route("/category/{id}", name="category_subcategory")
     */
    public function getSubCategoryByCategory(Categories $categoryId)
    {


        // $subcategory = $this->entityManager->getRepository(SubCategory::class)->findBy(['categories'=>$id]);
        // dd($subcategory);


        $subcategoryData = [];
        $categories = $this->entityManager->getRepository(Categories::class)->find($categoryId);
     //   dd($categories);

        $subcategories = $categories->getSubcategory();

        foreach ($subcategories as $subcategory) {
            if (!$subcategory->getId() == null) {
                // Traitez ici le cas où la catégorie "Français" n'existe pas
               // throw $this->createNotFoundException('La catégorie "Français" n\'existe pas.');

            // Vous pouvez accéder aux propriétés de chaque sous-catégorie ici
            $subcategoryName = $subcategory->getName();
           // dd($subcategoryName);
          //  $subcategoryDescription = $subcategory->getDescription();

            // Faites quelque chose avec les données de la sous-catégorie, par exemple, les stocker dans un tableau
            $subcategoryData[] = [
                'id' => $subcategory->getId(),
                'name' => $subcategoryName,
            //    'description' => $subcategoryDescription,
            ];
           // dd($subcategoryData);
        }

        }
        return new JsonResponse(['subcategories' => $subcategoryData]);
       // dd($subcategories);
       // foreach ($categories as $category) {

       //     dd($category);
      //  }


        /* {
         foreach ($appointments as $appointment) {
         $start = $appointment->getStart();
         $end = $appointment->getEnd();
         $interval = new \DateInterval('PT1H'); // Interval of 1 hour
         $period = new \DatePeriod($start, $interval, $end);

         foreach ($period as $date) {
         // $date_and_time = $date->format('d-m-Y H:i:s');
         //  $dates_only = $date->format('d-m-Y');
         // $times = $date->format('H:i:s');
         // $hours[] = [$dates_only, $times];

         //  $hours[] = [$date->format('d-m-Y'), $date->format('H:i:s')];
         // $date_and_time = $date->format('d-m-Y H:i:s');
         $date_and_time = $date->format('H:i:s');

         $date_only = $date->format('d-m-Y');
         $hours[$date_only][] = $date_and_time;
         }
         }
         $formatted_hours = [];
         foreach ($hours as $date => $time_array) {
         $formatted_hours[$date] = implode(', ', $time_array);
         }
         dd($formatted_hours);
          *
          }*/

        //  return new JsonResponse($hours);


        //return $formatted_hours;
    }

}
