<?php
namespace App\Entity;
use DateTime;


class MyDateTimeFilter extends DateTime
{
    public function __construct(DateTime $date, DateTime $time)
    {
        $this->date = $date;
        $this->time = $time;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getTime(): DateTime
    {
        return $this->time;
    }

    public function format(string $format): string
    {
        return $this->date->format($format) . ' ' . $this->time->format($format);
    }
}


