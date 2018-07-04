<?php

namespace Calendar\Expression;

use DateTime;

final class AndOperator implements ExpressionInterface
{
    /** @var ExpressionInterface */
    protected $expressions1;

    /** @var ExpressionInterface */
    protected $expressions2;

    public function __construct(ExpressionInterface $expressions1, ExpressionInterface $expressions2)
    {
        $this->expressions1 = $expressions1;
        $this->expressions2 = $expressions2;
    }

    public function isMatching(DateTime $date): bool
    {
        return $this->expressions1->isMatching($date) && $this->expressions2->isMatching($date);
    }

    public function __toString(): string
    {
        return sprintf("%s AND %s",
            $this->expressions1->__tostring(),
            $this->expressions2->__tostring()
        );
    }

}