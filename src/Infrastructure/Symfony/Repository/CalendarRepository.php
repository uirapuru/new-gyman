<?php

namespace App\Repository;

use Calendar\Calendar;
use Calendar\Repository\CalendarRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\UuidInterface;

class CalendarRepository extends EntityRepository implements CalendarRepositoryInterface
{
    public function save(Calendar $calendar): void
    {
        // TODO: Implement save() method.
    }

    public function findById(UuidInterface $uuid): ?Calendar
    {
        // TODO: Implement findById() method.
    }
}