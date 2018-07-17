<?php

namespace App\Controller;


use App\Form\Type\CreateEventType;
use Calendar\Calendar;
use Calendar\Command\CreateEvent;
use Calendar\Repository\CalendarRepositoryInterface;
use DateTime;
use League\Tactician\CommandBus;
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

        return $this->render("default/index.html.twig", [
            "events" => $events,
            "startDate" => $startDate,
            "endDate" => $endDate
        ]);
    }

    public function addEventAction(Request $request, CommandBus $bus, CalendarRepositoryInterface $repository) : Response
    {
        $calendars = array_reduce($repository->findAll(), function(&$result, Calendar $calendar) : array {
            $result[$calendar->name()] = $calendar->id()->toString();
            return $result;
        }, []);

        $command = CreateEvent::empty();

        $form = $this->createForm(CreateEventType::class, $command, ["calendars" => $calendars]);

        if($request->isMethod("POST")) {
            $form->handleRequest($request);

            if($form->isValid()) {
                $bus->handle($form->getData());
            }
        }

        return $this->render("default/addEvent.html.twig", [
            "form" => $form->createView()
        ]);
    }
}