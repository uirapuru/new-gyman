<?php

namespace Calendar\Expression;

use DateTime;

final class EveryDay implements ExpressionInterface
{
    public function isMatching(DateTime $date): bool
    {
        return true;
    }

    public function __toString(): string
    {
        return "everyday";
    }
}