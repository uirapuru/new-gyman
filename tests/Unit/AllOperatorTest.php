<?php

namespace Tests\Unit;

use Calendar\Expression\AllOperator;
use Calendar\Expression\DayOfWeek;
use Calendar\Expression\EveryDay;
use Calendar\Expression\GreatherThan;
use Calendar\Expression\LowerThan;
use DateTime;
use PHPUnit\Framework\TestCase;

class AllOperatorTest extends TestCase
{

    public function testToString()
    {
        $expression = new AllOperator(DayOfWeek::monday(), DayOfWeek::wednesday(), DayOfWeek::friday());

        $this->assertEquals("monday,wednesday,friday", (string) $expression);
    }

    public function testIsMatchingOne()
    {
        $expression = new AllOperator(DayOfWeek::tuesday());

        $this->assertTrue($expression->isMatching(new DateTime("tuesday")));
    }

    public function testIsMatchingFew()
    {
        $expression = new AllOperator(
            new GreatherThan(new DateTime("yesterday")),
            new EveryDay(),
            new DayOfWeek((int) (new DateTime("w"))->format("w")),
            new LowerThan(new DateTime("tomorrow"))
        );

        $this->assertTrue($expression->isMatching(new DateTime("today")));

        $expression = new AllOperator(
            new GreatherThan(new DateTime("tomorrow")),
            new LowerThan(new DateTime("yesterday"))
        );

        $this->assertFalse($expression->isMatching(new DateTime("today")));
    }
}
