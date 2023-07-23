<?php
// src/Controller/AppointmentController.php
namespace App\Controller;

use App\Entity\Appointment;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;



class AppointmentController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    // ...

    /**
     * @Route("/appointments/hours", name="appointments_hours")
     */
    public function getAppointmentHours()
    {
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
        }

           // dd($hours);
    //    return $this->render('teacher/show.html.twig', [
    //        'hours' => $hours,
    //    ]);

        return new JsonResponse($hours);
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

