<?php

namespace Calendar\Handler;

use Calendar\Command\CreateEvent;
use Calendar\Event;
use Calendar\Expression\Builder;
use Calendar\Repository\CalendarRepositoryInterface;
use Calendar\Repository\EventRepositoryInterface;
use Ramsey\Uuid\Uuid;

class CreateEventHandler
{
    /** @var CalendarRepositoryInterface */
    protected $calendarRepository;

    /** @var EventRepositoryInterface */
    protected $eventRepository;

    public function __construct(CalendarRepositoryInterface $calendarRepository, EventRepositoryInterface $eventRepository)
    {
        $this->calendarRepository = $calendarRepository;
        $this->eventRepository = $eventRepository;
    }

    public function handle(CreateEvent $command)
    {
        $calendar = $this->calendarRepository->findByName($command->calendarId());

        $expression = Builder::create()
            ->setStartDate($command->startDate())
            ->setEndDate($command->endDate())
            ->setDays($command->days())
            ->expression()
        ;

        $event = Event::create(Uuid::uuid4(), $calendar, $command->name(), $expression, $command->timeSpan());

        $calendar->addEvent($event);

        $this->calendarRepository->save($calendar);
        $this->eventRepository->save($event);
    }
}