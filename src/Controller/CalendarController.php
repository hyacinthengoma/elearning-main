<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Teachers;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class CalendarController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/calendar/{slug}", name="calendar")
     */
    public function index($slug, AppointmentRepository $appointment,Teachers $teacherResa): Response
    {
        $teachers = $this->entityManager->getRepository(Teachers::class)->findOneBySlug($slug);
        $events = $this->entityManager->getRepository(Appointment::class)->findOneBy(['teachers' => $teacherResa]);
        //dd($events);
        if ($events !== null) {
            $events = $this->entityManager->getRepository(Appointment::class)->findOneBy(['teachers' => $teacherResa]);
        } else {

            $teacher = $this->entityManager->getRepository(Teachers::class)->findOneById($teacherResa);
            return $this->render('teacher/calendar.html.twig', [
                'teachers' => $teachers
            ]);
        }
        // dd($teacher);
        //dd($events);
        $appointmentsbyteachers = $events->getTeachers();
        // dd($appointmentsbyteachers);
        $appointmentsbyteachersrefs = $appointmentsbyteachers->getId();
        //  dd($appointmentsbyteachersrefs);

        return $this->render('calendar/index.html.twig',[
            'teacher_id'=>$appointmentsbyteachersrefs,
            'teachers' => $teachers
        ]);





      //  $calendarId = 'hyacinthengoma-pro/test?month=2023-07';
       // $iframeCode = '<iframe src="https://calendar.google.com/calendar/embed?src='.$calendarId.'" width="800rem" height="600rem" frameborder="0" scrolling="no"></iframe>';

       // return $this->render('calendar/index.html.twig',
          //  'iframeCode' => $iframeCode,
       // );
    }
}
