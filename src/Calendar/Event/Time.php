<?php

namespace Calendar\Event;

use DateTime;
use Webmozart\Assert\Assert;

class Time
{
    /** @var int */
    protected $hour;

    /** @var int */
    protected $minutes;

    protected function __construct(int $hour, int $minutes)
    {
        Assert::range($hour, 0, 23);
        Assert::range($minutes, 0, 59);

        $this->hour = $hour;
        $this->minutes = $minutes;
    }

    static public function fromString(string $time) : self
    {
        return new self(...sscanf($time, "%d:%d"));
    }

    public function toDateTime() : \DateTime
    {
        return (new DateTime("now"))->modify(sprintf("%01d:%01d", $this->hour, $this->minutes));
    }

    public function __toString() : string
    {
        return sprintf(
            "%s:%s",
            str_pad($this->hour, 2, "0", STR_PAD_LEFT),
            str_pad($this->minutes, 2, "0", STR_PAD_LEFT)
        );
    }

    public function gt(Time $to) : bool
    {
        return $this->toDateTime() > $to->toDateTime();
    }

    public function lt(Time $to) : bool
    {
        return $this->toDateTime() < $to->toDateTime();
    }

    public function equals(Time $to) : bool
    {
        return $this->toDateTime() == $to->toDateTime();
    }
}