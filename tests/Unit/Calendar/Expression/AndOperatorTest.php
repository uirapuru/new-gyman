<?php

namespace Test\Unit\Calendar\Expression;

use Calendar\Expression\AndOperator;
use Calendar\Expression\DayOfWeek;
use Calendar\Expression\After;
use Calendar\Expression\Before;
use Calendar\Expression\OrOperator;
use DateTime;
use PHPUnit\Framework\TestCase;

class AndOperatorTest extends TestCase
{

    public function testToString()
    {
        $expression = new AndOperator(DayOfWeek::monday(), DayOfWeek::wednesday());

        $this->assertEquals("(monday and wednesday)", (string) $expression);
    }

    public function testIsMatchingOne()
    {
        $expression = new AndOperator(DayOfWeek::tuesday(), DayOfWeek::tuesday());

        $this->assertTrue($expression->isMatching(new DateTime("tuesday")));
    }

    public function testIsMatchingAll()
    {
        $expression = new AndOperator(DayOfWeek::tuesday(), DayOfWeek::tuesday());

        $this->assertTrue($expression->isMatching(new DateTime("tuesday")));
    }

    public function testIsNotMatchingOnlyFew()
    {
        $expression = new AndOperator(
            new DayOfWeek((int) (new DateTime("yesterday"))->format("w")),
            new DayOfWeek((int) (new DateTime("today"))->format("w"))
        );

        $this->assertFalse($expression->isMatching(new DateTime("today")));

        $expression = new AndOperator(
            new After(new DateTime("tomorrow")),
            new Before(new DateTime("yesterday"))
        );

        $this->assertFalse($expression->isMatching(new DateTime("today")));
    }

    public function testGaping()
    {
        $expression = new AndOperator(
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

        $this->assertTrue($expression->isMatching(new DateTime("2017-06-05")));
        $this->assertTrue($expression->isMatching(new DateTime("2017-06-07")));
        $this->assertTrue($expression->isMatching(new DateTime("2017-06-09")));

        $this->assertFalse($expression->isMatching(new DateTime("2017-07-07")));
        $this->assertFalse($expression->isMatching(new DateTime("2017-07-09")));
        $this->assertFalse($expression->isMatching(new DateTime("2017-07-11")));
    }
}
