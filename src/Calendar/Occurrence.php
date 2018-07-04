<?php

namespace Calendar;


use DateTime;

class Occurrence
{
    /** @var DateTime */
    protected $date;

    /** @var Event */
    protected $event;

    public function __construct(DateTime $date, Event $event)
    {
        $this->date = $date;
        $this->event = $event;
    }

    public function date(): DateTime
    {
        return $this->date;
    }

    public function event(): Event
    {
        return $this->event;
    }
}