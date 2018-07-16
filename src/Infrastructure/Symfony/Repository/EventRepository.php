<?php

namespace App\Repository;

use Calendar\Event;
use Calendar\Repository\EventRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository implements EventRepositoryInterface
{
    public function save(Event $event): void
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush($event);
    }
}