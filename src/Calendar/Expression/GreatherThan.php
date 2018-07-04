<?php

namespace Calendar\Expression;

use DateTime;

final class GreatherThan implements ExpressionInterface
{
    /** @var DateTime */
    protected $date;

    public function __construct(DateTime $date)
    {
        $this->date = $date;
    }

    public function isMatching(DateTime $date): bool
    {
        return $this->date < $date;
    }

    public function __toString(): string
    {
        return sprintf("greather than %s", $this->date->format("Y-m-d H:i:s"));
    }
}