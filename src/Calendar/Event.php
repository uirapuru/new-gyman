<?php

namespace Calendar;


use Calendar\Event\TimeSpan;
use Calendar\Expression\ExpressionInterface;
use Calendar\Expression\Parser;
use DateTime;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Uuid;

class Event
{
    /** @var UuidInterface */
    protected $id;

    /** @var string */
    protected $name;

    /** @var ExpressionInterface */
    protected $expression;

    /** @var TimeSpan */
    protected $time;

    public function __construct(UuidInterface $id, string $name, ExpressionInterface $expression, TimeSpan $time)
    {
        $this->id = $id;
        $this->name = $name;
        $this->expression = $expression;
        $this->time = $time;
    }

    public static function create(UuidInterface $id, string $name, string $expression, string $time)
    {
        return new self($id, $name, Parser::fromString($expression), TimeSpan::fromString($time));
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
        return (string) $this->expression;
    }
}