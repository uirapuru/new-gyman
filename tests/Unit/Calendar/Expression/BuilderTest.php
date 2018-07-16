<?php

namespace Test\Unit\Calendar\Expression;

use Calendar\Expression\Builder;
use DateTime;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    public function testExpression()
    {
        $expression = Builder::create()
            ->setStartDate(new DateTime("2018-01-01"))
            ->setEndDate(new DateTime("2018-01-30"))
            ->setMonday()
            ->setWednesday()
            ->setFriday()
            ->expression()
        ;

        $this->assertEquals("((monday or (wednesday or friday)) and (after 2018-01-01 and before 2018-01-01))", (string) $expression);

        $expression = Builder::create()
            ->setStartDate(new DateTime("2018-01-01"))
            ->setEndDate(new DateTime("2018-01-30"))
            ->expression()
        ;

        $this->assertEquals("(after 2018-01-01 and before 2018-01-01)", (string) $expression);

        $expression = Builder::create()
            ->setMonday()
            ->expression()
        ;

        $this->assertEquals("monday", (string) $expression);

        $expression = Builder::create()
            ->setStartDate(new DateTime("2018-01-01"))
            ->setFriday()
            ->expression()
        ;

        $this->assertEquals("(friday and after 2018-01-01)", (string) $expression);


        $expression = Builder::create()
            ->setDays(["monday", "friday"])
            ->expression()
        ;

        $this->assertEquals("(monday or friday)", (string) $expression);
    }
}
