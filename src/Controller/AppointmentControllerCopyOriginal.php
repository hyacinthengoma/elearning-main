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



class AppointmentControllerCopyOriginal extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    // ...

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
