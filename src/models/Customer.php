<?php

namespace App\models;

use DateTimeZone;

class Customer
{

    protected string $name;
    protected string $phoneNumber;
    protected ?string $address;
    protected DateTimeZone $timeZone;

    public function __construct(string $name, string $phoneNumber, string $timeZone = null, string $address = null)
    {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->timeZone = new DateTimeZone($timeZone ?? config('app.timezone'));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAddress() : string
    {
        return $this->address;
    }

    public function setAddress(string $address) : void
    {
        $this->address = $address;
    }

    public function getPhoneNumber() : string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber) : void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getTimeZone() : DateTimeZone
    {
        return $this->timeZone;
    }

    public function setTimeZone(string $timeZone) : void
    {
        $this->timeZone = new DateTimeZone($timeZone);
    }
}
