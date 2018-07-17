<?php

namespace Calendar\Repository;

use Calendar\Event;
use Ramsey\Uuid\UuidInterface;

interface EventRepositoryInterface
{
    public function save(Event $event) : void;

    public function findById(UuidInterface $eventId) : ?Event;
}