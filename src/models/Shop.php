<?php

namespace App\models;

class Shop
{
    protected string $name;
    protected string $location;
    protected array $invoices;

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setLocation($location) : void
    {
        $this->location = $location;
    }

    public function getLocation() : string
    {
        return $this->location;
    }

    public function getInvoices() : array
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice) : void
    {
        $this->invoices[] = $invoice;
    }

    public function setInvoices(array $invoices) : void
    {
        $this->invoices = $invoices;
    }
}
