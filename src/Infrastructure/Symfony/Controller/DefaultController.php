<?php

namespace App\Controller;


use App\Form\Type\CreateEventType;
use Calendar\Calendar;
use Calendar\Event;
use Calendar\Expression\Parser;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request) : Response
    {
        $collection = new ArrayCollection();
        $calendar = new Calendar(Uuid::uuid4(), "", $collection);
        $event = Event::create(Uuid::uuid4(), $calendar, "some name", Parser::fromString("monday"), "11:00-15:00");
        $collection->add($event);

        $events = $calendar->getOccurrences(new DateTime("2018-03-01"), new DateTime("2018-03-31"));

        dump($events);

        return $this->render("default/index.html.twig", [
            "events" => $events
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