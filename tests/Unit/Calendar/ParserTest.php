<?php

namespace Test\Unit\Calendar;

use Calendar\Expression\AndOperator;
use Calendar\Expression\DayOfWeek;
use Calendar\Expression\GreatherThan;
use Calendar\Expression\LowerThan;
use Calendar\Expression\Parser;
use DateTime;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParse()
    {
        $this->assertInstanceOf(AndOperator::class, Parser::parse("monday,friday"));
    }

    public function testMatching()
    {
        $expression = Parser::parse("monday,tuesday,wednesday,thursday,friday,saturday,sunday");

        $this->assertTrue($expression->isMatching(new DateTime("last monday")));
    }

    public function testParseOneDay()
    {
        $this->assertEquals(DayOfWeek::monday(), Parser::parse("monday"));
    }

    public function testParseGreatherThan()
    {
        $this->assertEquals(GreatherThan::fromString("2017-10-10 10:00:00"), Parser::parse("greather than 2017-10-10 10:00:00"));
    }

    public function testParseLowerThan()
    {
        $this->assertEquals(LowerThan::fromString("2017-10-10 10:00:00"), Parser::parse("lower than 2017-10-10 10:00:00"));
    }

    public function testParseUnparsable()
    {
        $this->expectExceptionMessage("Expression 'abc' can't be parsed");
        Parser::parse("abc");
    }

}
