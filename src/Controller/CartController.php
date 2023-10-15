<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\TeacherMetas;
use App\Entity\Teachers;
use App\Repository\AppointmentRepository;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/panier', name: 'cart')]
    public function index(SessionInterface $session, AppointmentRepository $appointmentRepository, Request $request): Response
    {
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

        //----------------------






        $appointments = $this->entityManager->getRepository(Appointment::class)->findBy(['teachers'=>$id]);
        // dd($appointments);
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






        //------------

      //  dd($panierWithData);
        return $this->render('cart/index.html.twig', [
            'appointments' => $panierWithData,
            'total' => $total,
           'hours' =>$hours
           // 'teachers' => $this->entityManager->getRepository(Teachers::class)->findAll()
        ]);
    }

    #[Route('/panier/add/{id}', name: 'cart_add')]
    public function add($id, SessionInterface $session ,Request $request): Response
    {

      //  $session = $request->getSession();
      //  $panier = $request->getSession();
      //  dd($session);
        $panier = $session->get('panier', []);
      //  dd($panier);

        if (!empty($panier[$id])){
            echo 'ce créneau à déja été ajouté à votre panier. Veuillez choisir un autre créneau';
        }
        else {

            $panier[$id] = 1;

        }

        $session->set('panier', $panier);

      //  dd($session->get('panier'));

     //   -------








        $appointments = $this->entityManager->getRepository(Appointment::class)->findBy(['teachers'=>$id]);
       // dd($appointments);
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

        return $this->render('cart/index.html.twig',[
            'hours' => $hours,
        ]);












        // Récupérez les événements du panier depuis la session Symfony

        /* $panier = $request->getSession()->get('cart', []);

        // Ajoutez l'événement au panier (vous devrez adapter cette partie en fonction de la structure de vos événements)
        $event = [
            'title' => 'Titre de l\'événement',
            'start' => 'Date de début',
            'end' => 'Date de fin',
        ];
        $panier[] = $event;

        // Mettez à jour la session Symfony avec le nouveau panier
        $request->getSession()->set('cart', $panier);

        // Redirigez l'utilisateur vers la page du panier
        return $this->redirectToRoute('cart');

        */
    }
    #[Route('/panier/remove/{id}', name: 'cart_remove')]
    public function remove($id, SessionInterface $session) {
        $panier = $session->get('panier',[]);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('cart');

    }

}
