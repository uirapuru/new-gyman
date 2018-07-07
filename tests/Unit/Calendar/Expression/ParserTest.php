<?php

namespace Test\Unit\Calendar\Expression;

use Calendar\Expression\After;
use Calendar\Expression\AndOperator;
use Calendar\Expression\Before;
use Calendar\Expression\DayOfWeek;
use Calendar\Expression\ExpressionInterface;
use Calendar\Expression\OrOperator;
use Calendar\Expression\Parser;
use DateTime;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParsing()
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

        /** @var ExpressionInterface $result */
        $result = Parser::fromString($string);

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

    public function testParseMultiAnd()
    {
        $expression = Parser::fromString("monday and tuesday and wednesday and thursday and friday and saturday and sunday");
        $this->assertFalse($expression->isMatching(new DateTime("now")));
        $string = (string) $expression;

        $expression2 = Parser::fromString($string);
        $this->assertFalse($expression2->isMatching(new DateTime("now")));
        $string2 = (string) $expression2;

        $this->assertEquals($string, $string2);

    }
    public function testParseMultiOr()
    {
        $expression = Parser::fromString("monday or tuesday or wednesday or thursday or friday or saturday or sunday");
        $this->assertTrue($expression->isMatching(new DateTime("now")));
        $string = (string) $expression;

        $expression2 = Parser::fromString($string);
        $this->assertTrue($expression2->isMatching(new DateTime("now")));
        $string2 = (string) $expression2;

        $this->assertEquals($string, $string2);
    }
}
