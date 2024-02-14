<?php

namespace App\services;


use App\models\Invoice;

class Invoices
{
    /**
     * @var Invoice[]
     */
    protected array $invoices = [];

    public function __construct(protected object $databaseLayer)
    {
    }

    /*
     * Assume this returns an Invoice object with its related Customer + Payment objects.
     * refer to return_array_with_one_invoice() in tests\InvoicesTest.php
     */

    /**
     * @return Invoice[]
     */
    public function get(): array
    {
        return $this->invoices;
    }

    /**
     * @return self
     */
    public function fetch() : self
    {
        $this->invoices = $this->databaseLayer->runQuery('select * from invoices...');
        return $this;
    }

    /**
     * @retun self
     */
    public function filterOverdue(): self
    {
        $this->invoices = array_filter($this->invoices, fn($invoice) => $invoice->isPaymentOverdue());
        return $this;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        $str = '';
        foreach ($this->invoices as $invoice) {
            $str .= $invoice->toString();
        }
        return $str . "--------------------------------\n\n";
    }
}
