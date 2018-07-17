<?php

namespace Calendar;

use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class Calendar
{
    /** @var UuidInterface */
    protected $id;

    /** @var string */
    protected $name;

    /** @var Event[]|array|Collection */
    protected $events;

    /** @var DateTime */
    protected $updatedAt;

    /** @var DateTime */
    protected $createdAt;

    public function __construct(UuidInterface $id, string $name, ?Collection $events = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->events = $events ?? new ArrayCollection();
        $this->createdAt = $this->updatedAt = new DateTime();
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function filterEvents(DateTime $date) : Collection
    {
        return $this->events->filter(function(Event $event) use ($date) : bool {
            return $event->isMatching($date);
        });
    }

    public function getOccurrences(DateTime $start, DateTime $end) : array
    {
        $period = new DatePeriod($start, new DateInterval('P1D'), $end->modify("+1 day"));

        $result = [];

        foreach($period as $day) {
            foreach($this->events as $event) {
                if($event->isMatching($day)) {
                    $result[] = new Occurrence($day, $event);
                }
            }
        }

        return $result;
    }

    public function addEvent(Event $event) : void
    {
        $this->events->add($event);
        $this->updatedAt = new DateTime();
    }

    public function removeEvent(Event $event) : void
    {
        foreach($this->events as $key => $value) {
            if($value === $event) {
                unset($this->events[$key]);
                break;
            }
        }

        $this->updatedAt = new DateTime();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function count() : int
    {
        return count($this->events);
    }

    public function matchingEvents(DateTime $date) : Collection
    {
        return $this->events->filter(function(Event $event) use ($date) : bool {
            return $event->isMatching($date);
        });
    }

    public function events() : array
    {
        return $this->events;
    }

    public function getEventByName(string $name) : ?Event
    {
        foreach($this->events as $event) {
            if($event->name() === $name) {
                return $event;
            }
        }

        return null;
    }
}