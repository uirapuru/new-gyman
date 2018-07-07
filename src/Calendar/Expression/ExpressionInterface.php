<?php

namespace Calendar\Expression;

use DateTime;

interface ExpressionInterface
{
    public function isMatching(DateTime $date) : bool;
    public function __toString() : string;
}