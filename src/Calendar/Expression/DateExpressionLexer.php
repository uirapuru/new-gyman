<?php

namespace Calendar\Expression;

use Dissect\Lexer\SimpleLexer;

class DateExpressionLexer extends SimpleLexer
{
    public function __construct()
    {
        $this
            ->token('or')
            ->token('and')
            ->regex('Day', '@^(monday|tuesday|wednesday|thursday|friday|saturday|sunday)@')
            ->regex('Lt', '@^(before \d{4}-\d{2}-\d{2})@')
            ->regex('Gt', '@^(after \d{4}-\d{2}-\d{2})@')
            ->regex('Eq', '@^(on \d{4}-\d{2}-\d{2})@')
            ->token('(')
            ->token(')')
        ;

        $this->regex('WSP', "/^[ \r\n\t]+/");
        $this->skip('WSP');
    }
}