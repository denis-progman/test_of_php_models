<?php

namespace App\models;

class Customer
{

    protected string $name;
    protected string $address;
    protected string $phone;
    protected string $timeZone;

    public function __construct(string $name)
    {
        $this->name = $name;
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
}
