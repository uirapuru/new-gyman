<?php

namespace Calendar\Expression;

use DateTime;

final class After implements ExpressionInterface
{
    /** @var DateTime */
    protected $date;

    public function __construct(DateTime $date)
    {
        $this->date = $date;
    }

    public function isMatching(DateTime $date): bool
    {
        return $this->date <= $date;
    }

    public function __toString(): string
    {
        return sprintf("after %s", $this->date->format("Y-m-d"));
    }

    public static function fromString(string $expression): ExpressionInterface
    {
        if(preg_match("@^(after \d{4}-\d{2}-\d{2}( \d{2}:\d{2}:\d{2})*)$@", $expression))
        {
            $expression = substr($expression, 6);
        }

        return new self(new DateTime($expression));
    }
}