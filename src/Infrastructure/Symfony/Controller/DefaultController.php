<?php

namespace App\Controller;


use Calendar\Calendar;
use Calendar\Event;
use Calendar\Expression\Parser;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
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
}