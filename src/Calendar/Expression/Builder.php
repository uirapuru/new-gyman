<?php

namespace Calendar\Expression;

use DateTime;

class Builder
{
    /** @var DateTIme */
    protected $startDate = null;

    /** @var DateTIme */
    protected $endDate = null;

    /** @var bool */
    protected $monday = false;

    /** @var bool */
    protected $tuesday = false;

    /** @var bool */
    protected $wednesday = false;

    /** @var bool */
    protected $thursday = false;

    /** @var bool */
    protected $friday = false;

    /** @var bool */
    protected $saturday = false;

    /** @var bool */
    protected $sunday = false;

    public static function create() : self {
        return new self();
    }

    public function setStartDate(?DateTime $dateTime = null) : self
    {
        $this->startDate = $dateTime;

        return $this;
    }

    public function setEndDate(?DateTime $dateTime = null) : self
    {
        $this->endDate = $dateTime;

        return $this;
    }

    public function setMonday(bool $monday = true): self
    {
        $this->monday = $monday;

        return $this;
    }

    public function setTuesday(bool $tuesday = true): self
    {
        $this->tuesday = $tuesday;

        return $this;
    }

    public function setWednesday(bool $wednesday = true): self
    {
        $this->wednesday = $wednesday;

        return $this;
    }

    public function setThursday(bool $thursday = true): self
    {
        $this->thursday = $thursday;

        return $this;
    }

    public function setFriday(bool $friday = true): self
    {
        $this->friday = $friday;

        return $this;
    }

    public function setSaturday(bool $saturday = true): self
    {
        $this->saturday = $saturday;

        return $this;
    }

    public function setSunday(bool $sunday = true): self
    {
        $this->sunday = $sunday;

        return $this;
    }

    public function expression() : ExpressionInterface
    {
        $array = [];

        $days = array_keys(array_filter([
            "monday" => $this->monday,
            "tuesday" => $this->tuesday,
            "wednesday" => $this->wednesday,
            "thursday" => $this->thursday,
            "friday" => $this->friday,
            "saturday" => $this->saturday,
            "sunday" => $this->sunday,
        ]));

        if(count($days) > 0) {
            $array[] = "(" . implode(" or ", $days) . ")";
        }

        if($this->startDate !== null) {
            $array[] = "after " . $this->startDate->format("Y-m-d");
        }

        if($this->endDate !== null) {
            $array[] = "before " . $this->startDate->format("Y-m-d");
        }

        return Parser::fromString(implode(" and ", $array));
    }

    public function setDays(array $days = []) : self
    {
        foreach($days as $day) {
            if(isset($this->$day)) {
                $this->$day = true;
            }
        }

        return $this;
    }
}