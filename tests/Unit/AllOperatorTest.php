<?php

namespace Tests\Unit;

use Calendar\Expression\AndOperator;
use Calendar\Expression\DayOfWeek;
use Calendar\Expression\GreatherThan;
use Calendar\Expression\LowerThan;
use DateTime;
use PHPUnit\Framework\TestCase;

class AllOperatorTest extends TestCase
{

    public function testToString()
    {
        $expression = new AndOperator(DayOfWeek::monday(), DayOfWeek::wednesday(), DayOfWeek::friday());

        $this->assertEquals("monday,wednesday,friday", (string) $expression);
    }

    public function testIsMatchingOne()
    {
        $expression = new AndOperator(DayOfWeek::tuesday());

        $this->assertTrue($expression->isMatching(new DateTime("tuesday")));
    }

    public function testIsMatchingFew()
    {
        $expression = new AndOperator(
            new GreatherThan(new DateTime("yesterday")),
            new DayOfWeek((int) (new DateTime("w"))->format("w")),
            new LowerThan(new DateTime("tomorrow"))
        );

        $this->assertTrue($expression->isMatching(new DateTime("today")));

        $expression = new AndOperator(
            new GreatherThan(new DateTime("tomorrow")),
            new LowerThan(new DateTime("yesterday"))
        );

        $this->assertFalse($expression->isMatching(new DateTime("today")));
    }
}
