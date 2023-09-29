<?php

namespace App\Controller;

use App\Entity\TeacherMetas;
use App\Entity\Teachers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/panier', name: 'cart')]
    public function index(Request $request): Response
    {
        // Récupérez les événements du panier depuis la session Symfony
        $panier = $request->getSession()->get('cart', []);

        return $this->render('cart/index.html.twig', [
            'events' => $panier,
            'teachers' => $this->entityManager->getRepository(Teachers::class)->findAll()
        ]);
    }

    #[Route('/panier/add/{id}', name: 'cart_add')]
    public function add($id, Request $request): Response
    {
        // Récupérez les événements du panier depuis la session Symfony
        $panier = $request->getSession()->get('cart', []);

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
    }
}
