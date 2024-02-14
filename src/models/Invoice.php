<?php

namespace App\models;

use App\models\Invoice\Payment;

class Invoice
{
    protected \DateTime $creationDate;
    protected ?Payment $payment = null;
    protected array $items;
    protected float $totalAmount = 0;

    public function __construct(protected ?Customer $customer = null)
    {

    }

    public function setCreationDate(\DateTime $date)
    {
        $this->creationDate = $date;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setPayment(Payment $payment) : void
    {
        $this->payment = $payment;
    }

    public function createPayment() : Payment
    {
        $this->payment = new Payment();

        return $this->payment;
    }

    public function getPayment() : Payment|null
    {
        return $this->payment;
    }

    public function setTotalAmount(float $amount) : void
    {
        $this->totalAmount = $amount;
    }

    public function getTotalAmount() : float
    {
        return $this->totalAmount;
    }
}
