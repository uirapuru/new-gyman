<?php

namespace Test;

use Calendar\Expression\After;
use Calendar\Expression\AndOperator;
use Calendar\Expression\Before;
use Calendar\Expression\DateExpressionGrammar;
use Calendar\Expression\DateExpressionLexer;
use Calendar\Expression\DateExpressionParser;
use Calendar\Expression\DayOfWeek;
use Calendar\Expression\ExpressionInterface;
use Calendar\Expression\OrOperator;
use PHPUnit\Framework\TestCase;

class LexerTest extends TestCase
{
    public function testTest()
    {
        $string = (string) new AndOperator(
            new OrOperator(
                DayOfWeek::monday(),
                new OrOperator(
                    DayOfWeek::wednesday(),
                    DayOfWeek::friday()
                )
            ),
            new OrOperator(
                new AndOperator(
                    After::fromString("2017-01-01"),
                    Before::fromString("2017-06-30")
                ),
                new AndOperator(
                    After::fromString("2017-09-01"),
                    Before::fromString("2017-12-31")
                )
            )
        );

        $this->assertEquals("((monday or (wednesday or friday)) and ((after 2017-01-01 and before 2017-06-30) or (after 2017-09-01 and before 2017-12-31)))", $string);

        $lexer = new DateExpressionLexer();
        $stream = $lexer->lex($string);

        $gramma = new DateExpressionGrammar();
        $parser = new DateExpressionParser($gramma);

        /** @var ExpressionInterface $result */
        $result = $parser->parse($stream);

        $this->assertEquals($string, $result);
        $this->assertInstanceOf(AndOperator::class, $result);

        $andOperatorExpressions = array_values((array) $result);

        $this->assertInstanceOf(OrOperator::class, $andOperatorExpressions[0]);
        $this->assertInstanceOf(OrOperator::class, $andOperatorExpressions[1]);

        $orOperatorExpressions = array_values((array) $andOperatorExpressions[0]);
        $this->assertInstanceOf(DayOfWeek::class, $orOperatorExpressions[0]);
        $this->assertInstanceOf(OrOperator::class, $orOperatorExpressions[1]);

        $orOperatorExpressions = array_values((array) $orOperatorExpressions[1]);
        $this->assertInstanceOf(DayOfWeek::class, $orOperatorExpressions[0]);
        $this->assertInstanceOf(DayOfWeek::class, $orOperatorExpressions[1]);

        $orOperatorExpressions = array_values((array) $andOperatorExpressions[1]);
        $this->assertInstanceOf(AndOperator::class, $orOperatorExpressions[0]);
        $this->assertInstanceOf(AndOperator::class, $orOperatorExpressions[1]);

        $andOperatorExpressions = array_values((array) $orOperatorExpressions[0]);
        $this->assertInstanceOf(After::class, $andOperatorExpressions[0]);
        $this->assertInstanceOf(Before::class, $andOperatorExpressions[1]);

        $andOperatorExpressions = array_values((array) $orOperatorExpressions[1]);
        $this->assertInstanceOf(After::class, $andOperatorExpressions[0]);
        $this->assertInstanceOf(Before::class, $andOperatorExpressions[1]);
    }
}
