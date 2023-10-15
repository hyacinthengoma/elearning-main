<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Teachers;
use App\Repository\AppointmentRepository;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function index($slug, SessionInterface $session, AppointmentRepository $appointmentRepository,Teachers $teacherResa): Response
    {
        $teachers = $this->entityManager->getRepository(Teachers::class)->findOneBySlug($slug);
       // $teachers = $this->entityManager->getRepository(Teachers::class)->findOneBy(['teachers' => $teacherResa]);
        //dd($teachers);
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


        $subcategories = $this->entityManager
            ->createQueryBuilder()
            ->select('s')
            ->from('App\Entity\SubCategory', 's')
            ->innerJoin('s.teachers', 't')
            ->getQuery()
            ->getResult();
//dd($subcategories);



        //----------------------------





        // Récupérez les événements du panier depuis la session Symfony
        $panier = $session->get('panier', []);
        //  dd($panier);
        //$panier = $request->getSession()->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity) {
            $panierWithData[] = [
                'appointments' => $appointmentRepository->findBy(['id' => $id]),
                'quantity' => $quantity
            ];
        }
       // dd($panierWithData);
        $total = 0;

        foreach($panierWithData as $item){


            if (isset($item['appointments'][0])) {
                $totalAppointment = $item['appointments'][0]->getPrice()/100 * $item['quantity'];
            } else {
                // Traitez le cas où l'élément n'existe pas
                $totalAppointment = 0; // Par exemple, si l'élément est absent, définissez le total à zéro
            }


            $total += $totalAppointment;
        }





        //----------------------------

        return $this->render('calendar/index.html.twig',[
            'teacher_id'=>$appointmentsbyteachersrefs,
            'teachers' => $teachers,
            'subcategories' =>$subcategories,


             'appointments' => $panierWithData,
            'total' => $total
        ]);





      //  $calendarId = 'hyacinthengoma-pro/test?month=2023-07';
       // $iframeCode = '<iframe src="https://calendar.google.com/calendar/embed?src='.$calendarId.'" width="800rem" height="600rem" frameborder="0" scrolling="no"></iframe>';

       // return $this->render('calendar/index.html.twig',
          //  'iframeCode' => $iframeCode,
       // );
    }

    #[Route('/calendar/add/{id}', name: 'cart_calendar_add')]
    public function add(SessionInterface $session,AppointmentRepository $appointmentRepository, Request $request): Response
    {

     //   $appointments = $this->entityManager->getRepository(Appointment::class)->findBy(['id' => $id]);


        //  $session = $request->getSession();
        //  $panier = $request->getSession();
        //  dd($session);
        $panier = $session->get('panier', []);
        $appointmentId = $request->query->get('id');
       // dd($panier);

        //  dd($panier);
        //  dd($panier);
        //$panier = $request->getSession()->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity) {
            $panierWithData[] = [
                'appointments' => $appointmentRepository->findBy(['id' => $id]),
                'quantity' => $quantity
            ];
        }
        if (!empty($panier[$id])){
            echo 'ce créneau à déja été ajouté à votre panier. Veuillez choisir un autre créneau';
        }
        else {

            $panier[$id] = 1;

        }

        $session->set('panier', $panier);
//dd($panier);

       // dd($session->get('panier'));

        //   -------












        //-----------------------------------




        $appointments = $this->entityManager->getRepository(Appointment::class)->findBy(['teachers'=>$id]);
//dd($appointments);
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
                    $currentHour = clone $nextHour;
dd($hours);
                }
            }
        }






        //_-----------------------------------








        return $this->render('calendar/index.html.twig', [
            'appointments' => $panierWithData
        ]);
    }
}
