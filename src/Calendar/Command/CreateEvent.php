<?php

namespace Calendar\Command;

use Calendar\Event\TimeSpan;
use DateTime;
use Ramsey\Uuid\UuidInterface;

class CreateEvent
{
    /** @var UuidInterface */
    protected $calendarId;

    /** @var string */
    protected $name;

    /** @var DateTime */
    protected $startDate;

    /** @var DateTime|null */
    protected $endDate;

    /** @var TimeSpan */
    protected $timeSpan;

    /** @var array */
    protected $days;

    public function __construct(UuidInterface $calendarId, string $name, DateTime $startDate, ?DateTime $endDate, TimeSpan $timeSpan, array $days)
    {
        $this->calendarId = $calendarId;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->timeSpan = $timeSpan;
        $this->days = $days;
    }

    public function calendarId(): UuidInterface
    {
        return $this->calendarId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function startDate(): DateTime
    {
        return $this->startDate;
    }

    public function endDate(): ?DateTime
    {
        return $this->endDate;
    }

    public function timeSpan(): TimeSpan
    {
        return $this->timeSpan;
    }

    public function days(): array
    {
        return $this->days;
    }
}