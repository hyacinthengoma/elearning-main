<?php
// src/Controller/AppointmentController.php
namespace App\Controller;
use App\Entity\Appointment;
use App\Entity\Teachers;
use App\Repository\AppointmentRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentControllerCopy extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/appointments/hours", name="appointments_hours")
     */
    public function getAppointmentHours($slug, AppointmentRepository $appointment,Teachers $teacherResa)
    {
        //$appointments = $this->entityManager->getRepository(Appointment::class)->findAll();
        $appointments = $this->entityManager->getRepository(Appointment::class)->findOneBy(['teachers' => $teacherResa]);
       //dd($appointments);

        if ($appointments !== null) {
            $appointments = $this->entityManager->getRepository(Appointment::class)->findOneBy(['teachers' => $teacherResa]);
        } else {

            $teacher = $this->entityManager->getRepository(Teachers::class)->findOneById($teacherResa);
            return $this->render('teacher/show.html.twig', [
                'teacher' => $teacher
            ]);
        }
        // dd($teacher);
        //dd($events);
        $appointmentsbyteachersrefs = [];
        $appointmentsbyteachers = $appointments->getTeachers();
        $appointmentsbyteachersrefs = $appointmentsbyteachers->getId();

        $rdv = [];
        foreach ($appointmentsbyteachersrefs as $appointmentsbyteachersref) {
            $rdv = [
                'id' => $appointmentsbyteachersref->getId(),
                'start' => $appointmentsbyteachersref->getStart()->format('Y-m-d H:i:s'),
                'end' => $appointmentsbyteachersref->getEnd()->format('Y-m-d H:i:s'),
                'title' => $appointmentsbyteachersref->getTitle(),

            ];
        }

          return new JsonResponse($rdv);
        //return $formatted_hours;
    }

    /**
     * @Route("/appointments/hours/{date}/{hour}", name="appointments_hours_by_day_and_hour")
     */
    public function findAppointmentsByDayAndHour(DateTimeInterface $start, string $hour): JsonResponse
    {
        $appointments = $this->entityManager->getRepository(Appointment::class)->findAppointmentsByDayAndHour($start, $hour);

        if (empty($appointments)) {
            return new JsonResponse([], 204);
        }
        return new JsonResponse($appointments);
    }
}
