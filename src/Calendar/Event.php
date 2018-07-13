<?php

namespace Calendar;

use Calendar\Event\TimeSpan;
use Calendar\Expression\ExpressionInterface;
use Calendar\Expression\Parser;
use DateTime;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Event
{
    /** @var UuidInterface */
    protected $id;

    /** @var string */
    protected $name;

    /** @var Calendar */
    protected $calendar;

    /** @var ExpressionInterface */
    protected $expression;

    /** @var TimeSpan */
    protected $time;

    /** @var DateTime */
    protected $updatedAt;

    /** @var DateTime */
    protected $createdAt;

    public function __construct(UuidInterface $id, Calendar $calendar, string $name, ExpressionInterface $expression, TimeSpan $time)
    {
        $this->id = $id;
        $this->calendar = $calendar;
        $this->name = $name;
        $this->expression = $expression;
        $this->time = $time;
        $this->createdAt = $this->updatedAt = new DateTime();
    }

    public static function create(UuidInterface $id, Calendar $calendar, string $name, string $expression, string $time)
    {
        return new self($id, $calendar, $name, Parser::fromString($expression), TimeSpan::fromString($time));
    }

    public function isMatching(DateTime $date) : bool
    {
        return $this->expression->isMatching($date);
    }

    public function duration() : int
    {
        return $this->time->minutes();
    }

    public function name() : string
    {
        return $this->name;
    }

    public function toString() : string
    {
        return (string) $this->id->toString() . ":" . $this->expression;
    }

    public function __toString() : string
    {
        return $this->toString();
    }

    public function id() : UuidInterface
    {
        return $this->id;
    }

    public function updateExpression(ExpressionInterface $expression)
    {
        $this->expression = $expression;
    }

    public function time() : TimeSpan
    {
        return $this->time;
    }
}