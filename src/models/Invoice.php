<?php

namespace App\models;

use App\models\Invoice\Payment;
use DateTime;
use Exception;

class Invoice
{
    protected \DateTime $creationDate;
    protected ?Payment $payment = null;
    protected array $items;
    protected float $totalAmount = 0;
    protected int $paymentDue;

    public function __construct(protected ?Customer $customer = null)
    {
        $this->paymentDue = config('invoice.payment_due');
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

    /**
     * @throws Exception
     */
    public function isPaymentOverdue() : bool
    {
        $now = new DateTime();
        $dueDate = (new DateTime($this->creationDate->format('Y-m-d')))->add(new \DateInterval("P{$this->paymentDue}D"));
        $now->setTimezone($this->customer->getTimeZone());
        return $now > $dueDate;
    }

    public function toString() : string
    {
        $str = "Customer: {$this->customer->getName()}\n";
        $str .= "Date: {$this->creationDate->format('Y-m-d')}\n";
        $str .= "Total Amount: {$this->totalAmount}\n";
        $str .= "Payment Date: " . ($this->payment?->getPaymentDate()?->format('Y-m-d') ?? 'Not Paid') . "\n";
        $str .= "Payment Amount: " . ($this->payment?->getAmount() ?? 'Not Paid') . "\n";
        $str .= "Timezone: {$this->customer->getTimeZone()->getName()}\n";
        $str .= "Is Payment Overdue: " . ($this->isPaymentOverdue() ? "Yes" : "No") . "\n";
        $str .= "\n";
        return $str;
    }
}
