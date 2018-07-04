<?php

namespace Test\Unit\Calendar;

use Calendar\Expression\AllOperator;
use Calendar\Expression\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{

    public function testParse()
    {
        $this->assertInstanceOf(AllOperator::class, Parser::parse("monday,friday"));
    }
}
