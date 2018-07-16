<?php

namespace Test\Infrastructure;

use Calendar\Event;
use Calendar\Repository\EventRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class InMemoryEventRepository implements EventRepositoryInterface
{
    /** @var Collection|null|Event[] */
    protected $events;

    public function __construct(?Collection $events = null)
    {
        $this->events = $events ?? new ArrayCollection();
    }

    public function save(Event $event): void
    {
        $this->events[$event->id()->toString()] = $event;
    }

    public function findById(UuidInterface $uuid) : ?Event
    {
        return $this->events[$uuid->toString()];
    }

    public function findAll() : Collection
    {
        return $this->events;
    }

    public function findByName(string $name) : ?Event
    {
        foreach($this->events as $event) {
            if($event->name() === $name) {
                return $event;
            }
        }

        return null;
    }
}