<?php

namespace Calendar\Expression;

use DateTime;

final class DayOfWeek implements ExpressionInterface
{
    /** @var integer */
    protected $dayOfWeek;

    protected const MONDAY = "monday";
    protected const TUESDAY = "tuesday";
    protected const WEDNESDAY = "wednesday";
    protected const THURSDAY = "thursday";
    protected const FRIDAY = "friday";
    protected const SATURDAY = "saturday";
    protected const SUNDAY = "sunday";

    protected static $days = [
        self::SUNDAY => 0,
        self::MONDAY => 1,
        self::TUESDAY => 2,
        self::WEDNESDAY => 3,
        self::THURSDAY => 4,
        self::FRIDAY => 5,
        self::SATURDAY => 6,
    ];

    public function __construct(int $dayOfWeek)
    {
        $this->dayOfWeek = $dayOfWeek;
    }

    static public function sunday(): self
    {
        return new self(
            self::$days[self::SUNDAY]
        );
    }

    static public function monday(): self
    {
        return new self(
            self::$days[self::MONDAY]
        );
    }

    static public function tuesday(): self
    {
        return new self(
            self::$days[self::TUESDAY]
        );
    }

    static public function wednesday(): self
    {
        return new self(
            self::$days[self::WEDNESDAY]
        );
    }
    static public function thursday(): self
    {
        return new self(
            self::$days[self::THURSDAY]
        );
    }

    static public function friday(): self
    {
        return new self(
            self::$days[self::FRIDAY]
        );
    }

    static public function saturday(): self
    {
        return new self(
            self::$days[self::SATURDAY]
        );
    }

    public function isMatching(DateTime $date): bool
    {
        return $date->format("w") == $this->dayOfWeek;
    }

    public function __toString(): string
    {
        return array_flip(self::$days)[$this->dayOfWeek];
    }
}