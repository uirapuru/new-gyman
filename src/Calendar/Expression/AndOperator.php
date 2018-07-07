<?php

namespace Calendar\Expression;

use BadMethodCallException;
use DateTime;

final class AndOperator implements ExpressionInterface
{
    /** @var ExpressionInterface */
    protected $expression1;

    /** @var ExpressionInterface */
    protected $expression2;

    public function __construct(ExpressionInterface $expression1, ExpressionInterface $expression2)
    {
        $this->expression1 = $expression1;
        $this->expression2 = $expression2;
    }

    public function isMatching(DateTime $date): bool
    {
        return $this->expression1->isMatching($date) && $this->expression2->isMatching($date);
    }

    public function __toString(): string
    {
        return "(" . $this->expression1 . " and " . $this->expression2 . ")";
    }
}