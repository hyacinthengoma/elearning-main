<?php

namespace App\Controller;

use App\Entity\Learners;
use App\Entity\Teachers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/chartjs', name: 'app_chartjs')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {


        $teachers = $this->entityManager->getRepository(Teachers::class)->findAll();
       // $learners = $this->entityManager->getRepository(Learners::class)->findAll();
        //Total de professeurs (1ere ligne en dessous)
        $teacherCount = count($teachers);
       //
        // $learnersCount = count($learners);
        // Créer un tableau pour stocker les données des enseignants
        $teacherData = [];
        $learnerData = [];

        // Parcourir tous les enseignants
        foreach ($teachers as $teacher) {
            // Récupérer les informations pertinentes (par exemple, le nom de l'enseignant et le nombre de formations)
            $teacherName = $teacher->getName();
            $trainingCount = $teacher->getTrainings()->count();

            // Ajouter les informations à notre tableau de données
            $teacherData[$teacherName] = $trainingCount;

        }


        /*foreach ($learners as $learner) {
            // Récupérer les informations pertinentes (par exemple, le nom de l'enseignant et le nombre de formations)

            $learnerName = $learner->getFirstname();

            $learnerCount = $learner->getLeaners()->count();
            dd($learnerCount);

            // Ajouter les informations à notre tableau de données
            $learnerData[$learnerName] = $learnerCount;

        }
        */
        //Total de professeurs (1ere ligne en dessous)
        $teacherData['Total Professeurs'] = $teacherCount;

        //Total de apprenants (1ere ligne en dessous)
      /*  $learnerData['Total apprenants'] = $learnerCount; */

      #  $teachers = $this->entityManager->getRepository(Teachers::class)->findAll();

        $chart = $chartBuilder->createChart(Chart::TYPE_PIE);
         # TYPE_LINE * TYPE_BAR * TYPE_RADAR * TYPE_PIE * TYPE_DOUGHNUT * TYPE_POLAR_AREA * TYPE_BUBBLE * TYPE_SCATTER #

        $chart->setData([
            'labels' => array_keys($teacherData),

            'datasets' => [
                [
                    'label' => 'Nombre de formations par professeurs | Nombre total de professeurs',
                    'backgroundColor' => 'rgb(47, 79, 79)',
                   // 'backgroundColor' => 'rgb(255, 99, 132, .4)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => array_values($teacherData),
                    'tension' => 0.4
                    ,
                ],


                /*    [
                        'label' => 'Nombre d\'apprenant',
                        'backgroundColor' => 'rgb(255, 99, 132, .4)',
                        'borderColor' => 'rgb(255, 99, 132)',
                        'data' => array_values($learnerData),
                        'tension' => 0.4
                    ],
*/
            ],
               // [
               //     'label' => 'Km walked 🏃‍♀️',
               //     'backgroundColor' => 'rgba(45, 220, 126, .4)',
               //     'borderColor' => 'rgba(45, 220, 126)',
               //     'data' => [10, 15, 4, 3, 25, 41, 25],
               //     'tension' => 0.4,
               // ],

        ]);

        $chart->setOptions([
            'maintainAspectRatio' => false,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'fontSize' => 60, // Taille de la police pour les étiquettes de légende
                    ],
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Statistiques des enseignants',
                    'fontSize' => 100, // Taille de la police pour le titre du graphique
                ],
                ],

        ]);

        return $this->render('chart/chartjs.html.twig', [
            'chart' => $chart,
        ]);
    }
}
