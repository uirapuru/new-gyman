<?php

namespace Calendar\Repository;

use Calendar\Calendar;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

interface CalendarRepositoryInterface
{
    public function save(Calendar $calendar): void;

    public function findById(UuidInterface $uuid): ?Calendar;
}