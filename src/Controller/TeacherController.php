<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Course;
use App\Entity\TeacherMetas;
use App\Entity\Teachers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     //   $description = $this->entityManager->getRepository(TeacherMetas::class)->findAll();
//dump($teachers);
        return $this->render('teacher/index.html.twig',[
            'teachers' => $teachers
        ]);
    }






    #[Route('/teacher/{slug}', name: 'teacher_info')]
    public function show($slug): Response
    {

//        dd($slug);
        $teachers = $this->entityManager->getRepository(Teachers::class)->findOneBySlug($slug);
//dump($teachers);
//dd($teacher);
      //  if(!$teacher){
      //      return $this->redirectToRoute('teacher');
      //  }




        $appointments = $this->entityManager->getRepository(Appointment::class)->findAll();
        $hours = [];

        foreach ($appointments as $appointment) {
            $start = $appointment->getStart();
            $end = $appointment->getEnd();
            $interval = new \DateInterval('PT1H'); // Interval of 1 hour
            $period = new \DatePeriod($start, $interval, $end);

            foreach ($period as $date) {
                $hours[] = $date->format('d-m-Y H:i:s');

            }
           // dd($hours);
        }


        return $this->render('teacher/show.html.twig', [
            'teachers'=> $teachers,
            'hours' => $hours
            //il faut que je rajoute à la vue la variable products qui va récuperer tous mes produits et les affichés
        ]);
    }

}
