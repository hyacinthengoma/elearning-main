<?php


namespace App\Entity;


use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
class MyDateTimeFilter implements DateTimeInterface
{
    private $date;
    private $time;

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