<?php

namespace Calendar\Expression;

use \Exception;

class Parser
{
    protected const CLASSMAP = [
        DayOfWeek::class    => "@^(monday|tuesday|wednesday|thursday|friday|saturday|sunday)$@",
        GreatherThan::class => "@^(greather than \d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})$@",
        LowerThan::class    => "@^(lower than \d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})$@",
    ];

    public static function parse(string $expression) : ExpressionInterface
    {
        $array = explode(",", $expression);

        if(count($array) === 1) {
            return self::getExpression($array[0]);
        } else {
            return new AndOperator(...array_map(function(string $expression){
                return self::parse($expression);
            }, $array));
        }
    }

    private static function getExpression(string $expression) : ExpressionInterface
    {
        foreach(self::CLASSMAP as $class => $regex) {
            if(preg_match($regex, $expression)) {
                return $class::fromString($expression);
            }
        }

        throw new Exception(sprintf("Expression '%s' can't be parsed", $expression));
    }
}