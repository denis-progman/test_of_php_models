<?php

namespace App\services;


class Invoices
{

    public function __construct(protected object $databaseLayer)
    {
    }

    /*
     * Assume this returns an Invoice object with its related Customer + Payment objects.
     * refer to return_array_with_one_invoice() in tests\InvoicesTest.php
     */
    public function fetchInvoices() : array
    {
        return $this->databaseLayer->runQuery('select * from invoices...');
    }
}
