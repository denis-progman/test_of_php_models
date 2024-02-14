<?php

use App\database\Connection;
use App\services\Invoices;

require 'core/procedures.php';
require 'config.php';
require __DIR__ . '/vendor/autoload.php';
require 'seeder.php';

/*
 * The receptionist will somehow run this php file to generate the list of folks to contact
 * This is in place of a neat web page in the staff CRM.
 */

// Set up our fake database
$databaseConnection = new Connection(seed());
$invoicesService = new Invoices($databaseConnection);

echo "Invoices:\n";

foreach ($invoicesService->fetchInvoices() as $invoice) {
    echo "Customer: {$invoice->getCustomer()->getName()}\n";
    echo "Date: {$invoice->getCreationDate()->format('Y-m-d')}\n";
    echo "Total Amount: {$invoice->getTotalAmount()}\n";
    echo "Payment Date: {$invoice->getPayment()?->getPaymentDate()->format('Y-m-d')}\n";
    echo "Payment Amount: {$invoice->getPayment()?->getAmount()}\n";
    echo "\n";
}
