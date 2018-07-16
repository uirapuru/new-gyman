<?php

namespace App\Controller;


use App\Form\Type\CreateEventType;
use App\Repository\CalendarRepository;
use Calendar\Calendar;
use Calendar\Event;
use Calendar\Expression\Parser;
use Calendar\Repository\CalendarRepositoryInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use const Grpc\CALL_ERROR_NOT_ON_CLIENT;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request, CalendarRepositoryInterface $calendarRepository) : Response
    {
        $calendars = $calendarRepository->findAll();
        $startDate = new DateTime("last monday");
        $endDate = clone $startDate;
        $endDate->modify("+7 days");

        $events = [];

        /** @var Calendar $calendar */
        foreach($calendars as $calendar) {
            $result = $calendar->getOccurrences($startDate, new DateTime("2018-03-31"));
            if(count($result) === 0) continue;
            array_push($events, ...$result);
        }

        dump($events);

        return $this->render("default/index.html.twig", [
            "events" => $events,
            "startDate" => $startDate,
            "endDate" => $endDate
        ]);
    }

    public function addEventAction(Request $request) : Response
    {
        $form = $this->createForm(CreateEventType::class, null, []);

        if($request->isMethod("POST")) {
            $form->handleRequest($request);

            if($form->isValid()) {
                $data = $form->getData();

                $this->get('tactician');
            }
        }

        return $this->render("default/addEvent.html.twig", [
            "form" => $form->createView()
        ]);
    }
}