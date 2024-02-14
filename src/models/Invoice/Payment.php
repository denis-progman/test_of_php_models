<?php

namespace App\models\Invoice;

use Exception;

class Payment
{
    protected \DateTime $paymentDate;
    protected float $amount;

    public function setPaymentDate(\DateTime $paymentDate) : void
    {
        $this->paymentDate = $paymentDate;
    }

    public function getPaymentDate() : \DateTime
    {
        return $this->paymentDate;
    }

    public function setAmount(float $amount) : void
    {
        if ($amount < 0) {
            throw new Exception('cannot set a negative payment amount');
        }

        $this->amount = $amount;
    }

    public function getAmount() : float
    {
        return $this->amount;
    }
}
