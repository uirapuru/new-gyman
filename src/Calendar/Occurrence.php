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

    public function __toString() : string
    {
        $timeSpan = $this->event->timespan();

        return json_encode([
            "title" => $this->event->name(),
            "start" => $this->date->format("Y-m-d") . "T" . $timeSpan->start() . ":00",
            "end" => $this->date->format("Y-m-d") . "T" . $timeSpan->end() . ":00",
        ]);
    }
}