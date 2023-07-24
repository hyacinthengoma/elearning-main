<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class CalendarController extends AbstractController
{

    /**
     * @Route("/calendar", name="calendar")
     */
    public function index(): Response
    {
        $calendarId = 'hyacinthengoma-pro/test?month=2023-07';
        $iframeCode = '<iframe src="https://calendar.google.com/calendar/embed?src='.$calendarId.'" width="800rem" height="600rem" frameborder="0" scrolling="no"></iframe>';

        return $this->render('calendar/index.html.twig', [
            'iframeCode' => $iframeCode,
        ]);
    }
}
