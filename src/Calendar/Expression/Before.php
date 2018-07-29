<?php

namespace Calendar\Expression;

use DateTime;

final class Before implements ExpressionInterface
{
    /** @var DateTime */
    protected $date;

    public function __construct(DateTime $date)
    {
        $this->date = $date;
        $this->date->modify("23:59:59");
    }

    public function isMatching(DateTime $date): bool
    {
        return $this->date >= $date;
    }

    public function __toString(): string
    {
        return sprintf("before %s", $this->date->format("Y-m-d"));
    }

    public static function fromString(string $expression): ExpressionInterface
    {
        if(preg_match("@^(before \d{4}-\d{2}-\d{2}( \d{2}:\d{2}:\d{2})*)$@", $expression))
        {
            $expression = substr($expression, 7);
        }

        return new self(new DateTime($expression));
    }
}