<?php

namespace App\models\Invoice;

use Exception;

class Payment
{
    protected \DateTime $date;
    protected float $amount;

    public function setDate(\DateTime $date) : void
    {
        $this->date = $date;
    }

    public function getDate() : \DateTime
    {
        return $this->date;
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
