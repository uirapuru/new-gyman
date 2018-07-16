<?php

namespace Calendar\Repository;

use Calendar\Event;

interface EventRepositoryInterface
{
    public function save(Event $event) : void;
}