<?php

namespace App\models;

use DateTimeZone;

class Customer
{

    protected string $name;
    protected string $address;
    protected string $phone;
    protected DateTimeZone $timeZone;

    public function __construct(string $name, string $timeZone = null)
    {
        $this->name = $name;
        $this->timeZone = new DateTimeZone($timeZone ?? config('app.timezone'));
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAddress(string $address) : void
    {
        $this->address = $address;
    }

    public function getAddress() : string
    {
        return $this->address;
    }

    public function setPhone(string $phone) : void
    {
        $this->phone = $phone;
    }

    public function getPhone() : string
    {
        return $this->phone;
    }

    public function setTimeZone(string $timeZone) : void
    {
        $this->timeZone = new DateTimeZone($timeZone);
    }

    public function getTimeZone() : DateTimeZone
    {
        return $this->timeZone;
    }
}
