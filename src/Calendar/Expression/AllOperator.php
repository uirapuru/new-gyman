<?php

namespace Calendar\Expression;

use BadMethodCallException;
use DateTime;

final class AllOperator implements ExpressionInterface
{
    /** @var ExpressionInterface[]|array */
    protected $expressions = [];

    public function __construct()
    {
        foreach(func_get_args() as $arg) {
            if(!$arg instanceof ExpressionInterface) {
                throw new BadMethodCallException("Must be ExpressionInterface implemented class!");
            }

            $this->expressions[] = $arg;
        }
    }

    public function isMatching(DateTime $date): bool
    {
        /** @var ExpressionInterface $expression */
        foreach($this->expressions as $expression) {
            if(!$expression->isMatching($date)) {
                return false;
            }
        }

        return true;
    }

    public function __toString(): string
    {
        return implode(",", array_map("strval", $this->expressions));
    }

}