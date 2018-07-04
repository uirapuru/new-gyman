<?php

namespace Test\Unit\Calendar\Event;

use function Calendar\cartesian_product;
use Calendar\Event\Time;
use DateTime;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testGet()
    {
        $times = cartesian_product([
            "hours" => range(0, 23, 3),
            "minutes" => range(0, 59, 3),
        ]);

        foreach ($times as $test) {
            $string = sprintf("%s:%s", $test[0], $test[1]);
            $time = Time::fromString($string);
            $this->assertEquals(new DateTime($string), $time->toDateTime());
        }
    }

    public function testToString()
    {
        $time = Time::fromString("23:11");
        $this->assertEquals("23:11", (string) $time);

        $time = Time::fromString("1:1");
        $this->assertEquals("01:01", (string) $time);
    }

    public function testGt()
    {
        $this->assertTrue(Time::fromString("11:00")->gt(Time::fromString("10:00")));
    }
}
