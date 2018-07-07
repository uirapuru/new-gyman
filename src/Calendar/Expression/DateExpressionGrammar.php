<?php

namespace Calendar\Expression;

use Dissect\Lexer\CommonToken;
use Dissect\Parser\Grammar;

class DateExpressionGrammar extends Grammar
{
    public function __construct()
    {
        $this("Expression")

            ->is('Expression','and','Expression')
            ->call(function($expression1,$operator,$expression2) {
                return new AndOperator($expression1, $expression2);
            })
            ->is('Expression','or','Expression')
            ->call(function($expression1,$operator,$expression2) {
                return new OrOperator($expression1, $expression2);
            })
            ->is('(','Expression',')')
            ->call(function($p,$expression,$p2) {
                return $expression;
            })
            ->is('Day')
            ->call(function(CommonToken $event) {
                return DayOfWeek::fromString($event->getValue());
            })
            ->is('Lt')
            ->call(function(CommonToken $event) {
                return Before::fromString($event->getValue());
            })
            ->is('Gt')
            ->call(function(CommonToken $event) {
                return After::fromString($event->getValue());
            })
            ->is('Eq')
            ->call(function(CommonToken $event) {
                return Exactly::fromString($event->getValue());
            })
        ;

        $this->start('Expression');
    }
}