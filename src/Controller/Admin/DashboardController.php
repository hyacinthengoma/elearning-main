<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Appointment;
use App\Entity\Categories;
use App\Entity\Course;
use App\Entity\CourseMetas;
use App\Entity\Learners;
use App\Entity\Level;
use App\Entity\SubCategories;
use App\Entity\TeacherMetas;
use App\Entity\Teachers;
use App\Entity\Training;
use App\Entity\TrainingMetas;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class DashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {

    }


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $url = $this->adminUrlGenerator
            ->setController(LearnersCrudController::class)
            ->generateUrl();


//        return parent::index();

        return $this->redirect($url);

//        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Plateforme de E learning')
            ->setLocales([
                'en' => '🇬🇧 English',
                'fr' => '🇫🇷 Français'])
            ->setFaviconPath('/uploads/jauge.jpeg');

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Dashboard','fa fa-dashboard')
            ->setCssClass('btn bg-dark text-white');
//        yield MenuItem::section('Dashboard', 'fa fa-home')
       // yield MenuItem::linkToCrud('Description des cours', 'fa-solid fa-key fa', CourseMetas::class);
        yield MenuItem::linkToCrud('Cours en visio', 'fa-solid fa-chalkboard-user', Course::class);
       // yield MenuItem::linkToUrl('Cours en visio', 'fa-solid fa-chalkboard-user', 'chartjs');
       // yield MenuItem::linkToCrud('Description des formations', 'fa-duoton fa-graduation-cap', TrainingMetas::class);
        yield MenuItem::linkToCrud('Formations', 'fa-duotone fa-graduation-cap', Training::class);
        yield MenuItem::linkToCrud('Professeurs', 'fa-solid fa-person-chalkboard', Teachers::class);
     //   yield MenuItem::linkToCrud('Description des professeurs', 'fa-solid fa-person-chalkboard', TeacherMetas::class);
        yield MenuItem::linkToCrud('Apprenants', 'fa-duotone fa-graduation-cap', Learners::class);
        yield MenuItem::linkToCrud('Categories', 'fa-duotone fa-graduation-cap', Categories::class);
        yield MenuItem::linkToCrud('Niveau', 'fa-duotone fa-graduation-cap', Level::class);
        yield MenuItem::linkToCrud('Calendrier', 'fa-duotone fa-graduation-cap', Appointment::class);

        yield MenuItem::linkToCrud('Administrateur (Moi)', 'fa-solid fa-person-chalkboard', Admin::class);
      //  yield MenuItem::linkToExitImpersonation('Stop impersonation', 'fa fa-exit');
    }
}
