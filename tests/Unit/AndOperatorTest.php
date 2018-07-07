<?php

namespace Tests\Unit;

use Calendar\Expression\AndOperator;
use Calendar\Expression\DayOfWeek;
use Calendar\Expression\After;
use Calendar\Expression\Before;
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
}
